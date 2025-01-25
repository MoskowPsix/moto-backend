<?php

namespace App\Contracts\Services;

interface GoogleSheetServiceContract
{
    public function create(string $table_name, array $fields, array $value): string;
}
