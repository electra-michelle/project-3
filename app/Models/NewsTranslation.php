<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsTranslation extends Model
{
    use HasFactory;
    protected $fillable = [
        'news_id',
        'locale',
        'title',
        'content'
    ];

    public $timestamps = false;
}
