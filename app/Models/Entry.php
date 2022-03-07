<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entry extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'label',
        'date',
        'text',
        'uuid',
        'file',
        'image',
        'datetime',
        'bool',
        'number',
        'json',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'date' => 'date',
        'datetime' => 'datetime',
        'bool' => 'boolean',
        'json' => 'array',
    ];
}
