<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    //This was not used in the final system


    //Shows the fields in the table that can be filled from the system
    protected $fillable = [
        'id',
        'title',
        'description',
    ];

    //A type belongs to many questions
    public function question()
    {
        return $this->belongsToMany('App\Question');
    }
}
