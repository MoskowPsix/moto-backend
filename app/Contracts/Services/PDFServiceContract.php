<?php

namespace App\Contracts\Services;

use App\Http\Resources\Errors\NotFoundResource;

interface PDFServiceContract
{
    public function create(array $fields): string|NotFoundResource;

    //Заполнение pdf шаблона файлами
    //fields массив полей с координатами (x,y), размерами (width, height) и значениями (value, align)
    //string путь к сгенерированному файлу
}
