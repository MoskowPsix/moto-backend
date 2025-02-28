<?php

namespace App\Console\Commands;

use App\Enums\DocumentType;
use App\Models\Document;
use App\Services\GoogleSheetService;
use Illuminate\Console\Command;

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
     */
    public function handle()
    {
        Document::all()->each(function ($apps) {
            $data = json_decode($apps->data, true);

            if (isset($data)) {
                if($apps->type->value === DocumentType::Polis->value) {
                    $apps->update([
                        'type' => 'polis',
                        'url_view' => $data['polisFileLink'] ?? 'https://dev-moto.vokrug.city/document/' . $apps->id,
                        'number' => $data['polisNumber'] ?? '',
                        'issued_whom' => $data['polisIssuedWhom'] ?? '',
                        'it_works_date' => $data['polisItWorksDate'] ?? '',
                    ]);
                }
                if($apps->type->value === DocumentType::Licenses->value) {
                    $apps->update([
                        'type' => 'licenses',
                        'url_view' => $data['licensesFileLink'] ?? 'https://dev-moto.vokrug.city/document/' . $apps->id,
                        'number' => $data['licensesNumber'] ?? '',
                    ]);
                }
                if($apps->type->value === DocumentType::Notarius->value) {
                    $apps->update([
                        'type' => 'notarius',
                        'url_view' => $data['notariusFileLink'] ?? 'https://dev-moto.vokrug.city/document/' . $apps->id,
                    ]);
                }
            }
        });
        return 1;
    }
}
