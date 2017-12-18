<?php
namespace GL\Console\Commands;

use GL\Models\BaseStation\ChinaMobile;
use GL\Models\BaseStation\ChinaTelecom;
use GL\Models\BaseStation\ChinaUnicom;
use GL\Support\Helpers\Carbon as CarbonHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\InputOption;

class ImportBaseStationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'base_stations:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import base stations from text file to database.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "Try to import base stations.\n";

        $file = ($this->hasOption('file') ? $this->option('file') : null) ?: 'base_stations.csv';
        $file = storage_path('source/' . $file);

        if (!file_exists($file)) {
            echo sprintf("Error: File(%s) is not exists.\n", $file);
            return;
        }

        $total = $this->import($file);

        echo sprintf("Finished import %s records of base stations.\n", $total);
    }

    public function import($file)
    {
        $index = 0;

        $file = fopen($file,'r');

        $pendingCommit = 0;
        // get one line
        while ($data = fgetcsv($file)) {
            // replace tab
            $lineStr  = str_replace("\t", "*****", $data[0]);
            // explode string to array
            $lineData = explode('*****', $lineStr);

            // $data = [
            //     0  => "460",         // mcc 所有的都是460,表示中国
            //     1  => "0",           // mnc 0表示移动基站,1表示联通基站,
            //                          // 11表示电信LTE基站10000-20000表示电信CDMA基站，此时此字段的取值并非MNC，实际为电信SID
            //     2  => "33061",       // lac 电信为nid
            //     3  => "13256",       // cell id 电信为bid
            //     4  => "30.573833",   // lat
            //     5  => "104.292610",  // lon
            //     6  => "175",         // acc 覆盖范围米
            //     7  => "20171030",    // date
            //     8  => "0.66",        // 精度   （正常无此字段）
            //     9  => "四川省成都市龙泉驿区龙泉街道百工堰村;枇杷沟路与公园路路口南812米",  // addr
            //     10 => "四川省",       // province
            //     11 => "成都市",       // city
            //     12 => "龙泉驿区",     // district
            //     13 => "龙泉街道",     // township
            // ];

            // remove index of 8 if count is 14, sometimes this field is not exists
            if (count($lineData) == 14) {
                unset($lineData[8]);
                $lineData = array_values($lineData);
            }

            // validation
            if (count($lineData) != 13 || 460 != $lineData[0]) {
                echo $this->echo(sprintf("Invalid, line index: %s.\n", ++$index));
                break;
            }

            list($mcc, $mnc, $lac, $cellId,
                 $lat, $lon, $radius, $dateRefreshAt,
                 $address, $province, $city, $district, $township)
                 = $lineData;

            $dateRefreshAt = CarbonHelper::create($dateRefreshAt);

            switch ($mnc) {
                case 0:
                    if (ChinaMobile::findBy($lac, $cellId)) {
                        $this->echo(sprintf("Exists, china mobile, line index: %s.\n", ++$index));
                        break;
                    }

                    if ($pendingCommit == 0) {
                        DB::beginTransaction();
                    }

                    ChinaMobile::shape($lac, $cellId, $lat, $lon, $radius,
                                       $province, $city, $district, $township,
                                       $address, $dateRefreshAt);
                    $this->echo(sprintf("China mobile, line index: %s.\n", ++$index));

                    $pendingCommit++;
                    break;
                case 1:
                    if (ChinaUnicom::findBy($lac, $cellId)) {
                        $this->echo(sprintf("Exists, china unicom, line index: %s.\n", ++$index));
                        break;
                    }

                    if ($pendingCommit == 0) {
                        DB::beginTransaction();
                    }

                    ChinaUnicom::shape($lac, $cellId, $lat, $lon, $radius,
                                       $province, $city, $district, $township,
                                       $address, $dateRefreshAt);
                    $this->echo(sprintf("China unicom, line index: %s.\n", ++$index));

                    $pendingCommit++;
                    break;
                default:
                    if (ChinaTelecom::findBy($mnc, $lac, $cellId)) {
                        $this->echo(sprintf("Exists, china telecom, line index: %s.\n", ++$index));
                        break;
                    }

                    if ($pendingCommit == 0) {
                        DB::beginTransaction();
                    }

                    ChinaTelecom::shape($mnc, $lac, $cellId, $lat, $lon, $radius,
                                        $province, $city, $district, $township,
                                        $address, $dateRefreshAt);
                    $this->echo(sprintf("China telecom, line index: %s.\n", ++$index));

                    $pendingCommit++;
                    break;
            }

            if ($pendingCommit % 10000 == 0) {
                DB::commit();
                $pendingCommit = 0;
            }
        }

        if ($pendingCommit > 0) {
            DB::commit();
        }

        fclose($file);

        return $index;
    }

    private function echo($str)
    {
        if ('testing' != env('APP_ENV')) {
            echo $str;
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['file', 'f', InputOption::VALUE_OPTIONAL, 'file name for import, default is base_stations.csv.'],
        ];
    }
}
