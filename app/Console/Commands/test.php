<?php

namespace App\Console\Commands;

use App\Contracts\Services\SecondCheckServiceContract;
use App\Enums\DocumentType;
use App\Models\Document;
use App\Models\Phone;
use App\Models\Transaction;
use App\Models\User;
use App\Services\GoogleSheetService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sheet {transaction_id}';

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
        $id = $this->argument('transaction_id');
        $transaction = Transaction::find($id);

        if (!$transaction) {
            $this->error("Транзакция с ID {$id} не найдена.");
            return 1;
        }

        /** @var SecondCheckServiceContract $secondCheck */
        $secondCheck = app(SecondCheckServiceContract::class);

        $response = $secondCheck->send($transaction);

        $this->info("HTTP код: " . $response['http_code']);
        $this->line("Ответ Robokassa:");
        dump($response['response']);

        if ($response['error']) {
            $this->error("Ошибка CURL: " . $response['error']);
        }

        return 0;

//        \App\Models\Command::query()->each(function ($command) {
//            $command->coaches()->attach($command->user_id);
//        });
//        return 0;
    }
}
