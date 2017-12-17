<?php
namespace Icar\Console\Commands;

use GL\Models\BaseStation\ChinaMobile;
use GL\Models\BaseStation\ChinaTelecom;
use GL\Models\BaseStation\ChinaUnicom;
use Illuminate\Console\Command;
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
            //     8  => "0.66",        // 精度
            //     9  => "四川省成都市龙泉驿区龙泉街道百工堰村;枇杷沟路与公园路路口南812米",  // addr
            //     10 => "四川省",       // province
            //     11 => "成都市",       // city
            //     12 => "龙泉驿区",     // district
            //     13 => "龙泉街道",     // township
            // ];

            if (count($lineData) != 14 || 460 != $lineData[0]) {
                echo $this->echo(sprintf("Invalid, line index: %s.\n", ++$index));
                break;
            }

            // var_dump($lineData);
            switch ($lineData[1]) {
                case 0:
                    if (ChinaMobile::findBy($lineData[2], $lineData[3])) {
                        $this->echo(sprintf("Exists, china mobile, line index: %s.\n", ++$index));
                        break;
                    }

                    ChinaMobile::shape($lineData[2], $lineData[3], $lineData[4], $lineData[5], $lineData[6],
                                 $lineData[10], $lineData[11], $lineData[12], $lineData[13], $lineData[9]);
                    $this->echo(sprintf("China mobile, line index: %s.\n", ++$index));
                    break;
                case 1:
                    if (ChinaUnicom::findBy($lineData[2], $lineData[3])) {
                        $this->echo(sprintf("Exists, china unicom, line index: %s.\n", ++$index));
                        break;
                    }

                    ChinaUnicom::shape($lineData[2], $lineData[3], $lineData[4], $lineData[5], $lineData[6],
                                       $lineData[10], $lineData[11], $lineData[12], $lineData[13], $lineData[9]);
                    $this->echo(sprintf("China unicom, line index: %s.\n", ++$index));
                    break;
                default:
                    if (ChinaTelecom::findBy($lineData[1], $lineData[2], $lineData[3])) {
                        $this->echo(sprintf("Exists, china telecom, line index: %s.\n", ++$index));
                        break;
                    }

                    ChinaTelecom::shape($lineData[1], $lineData[2], $lineData[3], $lineData[4], $lineData[5], $lineData[6],
                                        $lineData[10], $lineData[11], $lineData[12], $lineData[13], $lineData[9]);
                    $this->echo(sprintf("China telecom, line index: %s.\n", ++$index));
                    break;
            }
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