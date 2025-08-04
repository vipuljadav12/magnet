<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Languages extends Model
{
    public $table = 'languages';
    public $primaryKey = "id";
    public $fillable = [
        'language','language_code', 'default'
    ];
}
