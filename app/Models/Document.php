<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\DocumentType;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create()
 */
class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'path',
        'data',
        'url_view',
        'number',
        'issued_whom',
        'it_works_date',
        'is_checked',
        'user_id',
    ];

    protected $casts = [
        'type' => DocumentType::class,
        'data' => 'encrypted',
        'number' => 'encrypted',
        'issued_whom' => 'encrypted',
        'it_works_date' => 'encrypted',
    ];

}
