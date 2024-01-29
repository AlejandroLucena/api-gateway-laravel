<?php

namespace Modules\Post\Domain\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'content',
    ];

    protected $hidden = [
    ];

    protected $keyType = 'string';

    public $incrementing = false;
}
