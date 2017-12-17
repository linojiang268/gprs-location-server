<?php
namespace Icar\Console\Commands;

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

        $file = $this->hasOption('file') ? $this->option('file') : null;
        if (is_null($file)) {
            $file = 'base_stations.csv';
        }

        if (!file_exists($file)) {
            echo sprintf("Error: File(%s) is not exists.\n", $file);
            return;
        }

        $this->import($file);

        echo "Finished import base stations.\n";
    }

    public function import($file)
    {
        $index = 1;

        $file = fopen($file,'r');
        // 每次读取CSV里面的一行内容
        while ($data = fgetcsv($file)) {
            $lineStr  = str_replace("\t", "*****", $data[0]);
            $lineData = explode('*****', $lineStr);

            var_dump($lineData);
            echo sprintf("line index: %s.\n", $index++);
            break;
        }

        fclose($file);
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
