<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class WordGalaxy extends Model
{
    public $table = 'word_galaxy';
    public $primaryKey = "id";
    public $fillable = [
        'word_sentence','language', 'word_sentence_value'
    ];
}
