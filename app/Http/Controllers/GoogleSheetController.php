<?php

namespace App\Http\Controllers;

use App\Contracts\Services\GoogleSheetServiceContract;
use App\Models\User;
use Google\Service\Sheets\Sheet;
use Revolution\Google\Sheets\Facades\Sheets;
class GoogleSheetController extends Controller
{
    public function index(GoogleSheetServiceContract $service)
    {
        $data = User::all()->toArray();
        $fields = ['email', 'name'];
        $table_name = 'users';
        $url = $service->create($table_name, $fields, $data);

        dd($url);
    }
}
