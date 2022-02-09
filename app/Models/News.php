<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    use Translatable;

    protected $fillable = [
        'image', 'published_from'
    ];
    public $translatedAttributes = ['title', 'content'];
}
