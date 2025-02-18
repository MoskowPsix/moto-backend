<?php

namespace App\Console\Commands;

use App\Models\AppointmentRace;
use App\Models\Race;
use App\Models\User;
use Illuminate\Console\Command;

class FixUserApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-user-app';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private string $url = 'https://moto.vokrug.city/document/';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        AppointmentRace::query()->each(function ($app) {
            $user = User::find($app->user_id);
            $pers = $user->personalInfo()->first();

            $data = json_decode($app->data);
            $new_data = $data;
//            Паспорт
//            if (strlen($data->numberAndSeria) === 0) {
//                if (!empty($pers->number_and_seria) && strlen($pers->number_and_seria) !== 0) {
//                    $new_data->numberAndSeria = $pers->number_and_seria;
//                    $app->update([
//                        'data' => json_encode($new_data)
//                    ]);
//                }
//            }
            try {
                $user->documents()->each(function ($doc) use ($new_data) {
                    switch ($doc->type) {
                        case "licenses":
                            if (empty($new_data->licensesFileLink)) {
                                $new_data->licensesFileLink = $this->url . $doc->id;
                            } else {
                                if (str_starts_with($new_data->licensesFileLink, 'user')) {
                                    $new_data->licensesFileLink = $this->url . $doc->id;
                                }
                                if (strlen($new_data->licensesFileLink) === 0) {
                                    $new_data->licensesFileLink = $this->url . $doc->id;
                                }
                            }
                            break;
                        case "polis":
                            if (empty($new_data->polisFileLink)) {
                                $new_data->polisFileLink = $this->url . $doc->id;
                            } else {
                                if (str_starts_with($new_data->polisFileLink, 'user')) {
                                    $new_data->polisFileLink = $this->url . $doc->id;
                                }
                                if (strlen($new_data->polisFileLink) === 0) {
                                    $new_data->polisFileLink = $this->url . $doc->id;
                                }
                            }
                            break;
                        case "notarius":
                            if (empty($new_data->notariusFileLink)) {
                                $new_data->notariusFileLink = $this->url . $doc->id;
                            } else {
                                if (str_starts_with($new_data->notariusFileLink, 'user')) {
                                    $new_data->notariusFileLink = $this->url . $doc->id;
                                }
                                if (strlen($new_data->notariusFileLink) === 0) {
                                    $new_data->notariusFileLink = $this->url . $doc->id;
                                }
                            }
                            break;
                        default:
                            break;
                    }
                });
            } catch (\Exception $e) {
                dd($new_data);
            }
            $app->update([
                'data' => json_encode($new_data)
            ]);
        });
    }
}
