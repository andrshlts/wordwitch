<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Utility\Anagram as AnagramHelper;

class Word extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['word', 'key'];

    protected static function booted()
    {
        static::creating(function ($word) {
            $word->key = AnagramHelper::getAnagramKey($word->word);
        });

        static::updating(function ($word) {
            $word->key = AnagramHelper::getAnagramKey($word->word);
        });
    }
}