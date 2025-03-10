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
        $login = env('ROBOKASSA_LOGIN');
        $password = env('ROBOKASSA_TEST_PASSWORD1');

        $invoiceId = 678678;
        $description = 'Услуга от 500';
        $outSum = 500;
        $IsTest = 1;

        $crc = md5("$login:$outSum:$invoiceId:$password");

        $link = "https://auth.robokassa.ru/Merchant/Index.aspx?" .
            http_build_query([
                'MrchLogin' => $login,
                'OutSum' => $outSum,
                'InvId' => $invoiceId,
                'Desc' => $description,
                'SignatureValue' => strtoupper($crc),
                'IsTest' => $IsTest,
            ]);
        $this->info("Перейдите по следующей ссылке для тестовой оплаты:");
        $this->line($link);

//        Document::all()->each(function ($apps) {
//            $data = json_decode($apps->data, true);
//
//            if (isset($data)) {
//                if($apps->type->value === DocumentType::Polis->value) {
//                    $apps->update([
//                        'type' => 'polis',
//                        'url_view' => $data['polisFileLink'] ?? 'https://dev-moto.vokrug.city/document/' . $apps->id,
//                        'number' => $data['polisNumber'] ?? '',
//                        'issued_whom' => $data['polisIssuedWhom'] ?? '',
//                        'it_works_date' => $data['polisItWorksDate'] ?? '',
//                    ]);
//                }
//                if($apps->type->value === DocumentType::Licenses->value) {
//                    $apps->update([
//                        'type' => 'licenses',
//                        'url_view' => $data['licensesFileLink'] ?? 'https://dev-moto.vokrug.city/document/' . $apps->id,
//                        'number' => $data['licensesNumber'] ?? '',
//                    ]);
//                }
//                if($apps->type->value === DocumentType::Notarius->value) {
//                    $apps->update([
//                        'type' => 'notarius',
//                        'url_view' => $data['notariusFileLink'] ?? 'https://dev-moto.vokrug.city/document/' . $apps->id,
//                    ]);
//                }
//            }
//        });
//        return 1;
//    }
    }
}
