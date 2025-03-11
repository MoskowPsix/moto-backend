<?php

namespace App\Console\Commands;

use App\Enums\DocumentType;
use App\Models\Document;
use App\Services\GoogleSheetService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Unetway\LaravelRobokassa\Robokassa;

class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sheet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @throws \Exception
     */
    public function handle()
    {
        $key = '1P2enXHUZrAux3kcD8S67cec5d998cd7de24485f155604cf921cf88bf9895a6f';
        $method = 'push_msg';
        $format = 'json';
        $phone = 79920178526;
        $time = 60;
        $text = 1114;
        $name = 'moto.vokrug';
        $ch = curl_init('https://ssl.bs00.ru/?key=' . $key .
            '&method=' . $method .
            '&format=' . $format .
            '&phone=' . $phone .
            '&route=pc' .
            '&text=' . $text .
            '&sender_name=' . $name .
            '&call_protection=' . $time
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res, true);
        dd($res);
        return 0;
    }
}
