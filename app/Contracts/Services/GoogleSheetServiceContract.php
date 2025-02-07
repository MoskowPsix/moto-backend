<?php

namespace App\Contracts\Services;

use App\Models\Race;

interface GoogleSheetServiceContract
{
    public function create(string $table_name, array $fields, array $value, Race $race): object;
    public function update(string $id, array $fields = [], array $value = [], Race $race): object;
}
