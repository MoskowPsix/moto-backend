<?php

namespace App\Services\PDF;

use Illuminate\Support\Facades\File;

class PDFPathChecker
{
    protected string $path;
    public function __construct(string $path){
        $this->path = $path;
    }
    //Проверка существования шаблона
    public function checkPath(): bool
    {
        return File::exists($this->path);
    }
}
