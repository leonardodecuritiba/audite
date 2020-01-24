<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExportDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:exportdb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $filename = "systempaulista.sql";
        $cmd =
            "mysqldump -h " . env('DB_HOST') .
            " -u "          . env('DB_USERNAME') .
            " -p\""         . env('DB_PASSWORD') . "\"" .
            " " . env('DB_DATABASE') ."  > ". $filename;

        $output = [];

        exec($cmd, $output);

//        $tmppath = tempnam(sys_get_temp_dir(), $filename);
//        $handle = fopen($tmppath, "w");
//        fwrite($handle, implode($output, "\n"));

    }
}
