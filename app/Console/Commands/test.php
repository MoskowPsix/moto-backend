<?php

namespace App\Console\Commands;

use App\Enums\DocumentType;
use App\Models\Document;
use App\Models\Phone;
use App\Models\User;
use App\Services\GoogleSheetService;
use Exception;
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
        // Не трогать и не перекрывать код. Я потом сам его уберу, когда посчитаю нужным. bolshe.kivi
        User::query()->orderBy('id')->chunk(1000, function ($users) {
            $users->each(function ($user) {
                if ($user->personalInfo()->exists()) {
                    $phone = $user->personalInfo()->first()->phone_number;
                    $phone = rtrim($phone);
                    $phone = preg_replace('/[^0-9]/', '', $phone);
                    if (isset($phone) && strlen($phone) !== 0) {
                        if (strlen($phone) === 11) {
                            $phone[0] = "7";
                        } elseif(strlen($phone) === 10) {
                            $phone = "7" . $phone;
                        }
                        if (strlen($phone) === 11)
                        {
                            if ($user->phone()->exists() && !Phone::where('number', $phone)->exists()) {
                                    $user->phone()->update([
                                        'number' => $phone,
                                        'last_num' => (string)substr($phone, -4),
                                    ]);
                            } else {
                                $user->phone()->create([
                                    'number' => $phone,
                                    'last_num' => (string)substr($phone, -4),
                                ]);
                            }
                        }
                    }

                }
            });
        });
        return 0;
    }
}
