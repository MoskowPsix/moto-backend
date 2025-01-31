<?php

namespace App\Contracts\Services;

interface GoogleSheetServiceContract
{
    public function create(string $table_name, array $fields, array $value): object;
    public function update(string $id, array $fields = [], array $value = []): object;
}
