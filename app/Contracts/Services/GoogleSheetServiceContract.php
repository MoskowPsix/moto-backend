<?php

namespace App\Contracts\Services;

use App\Models\Race;

interface GoogleSheetServiceContract
{
    public function create(string $table_name, Race $race, array $fields, array $value): object;
    public function update(string $id, Race $race, array $fields = [], array $value = []): object;
}
