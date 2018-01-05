<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    //names the table
    protected $table = 'option';

    //Shows the fields in the table that can be filled from the system
    protected $fillable = [
        'id',
        'title',
        'description',
        'question_id',
    ];

    //An Option has one question
    public function question()
    {
        return $this->belongsTo('App\Models\Question', 'question_id');
    }
}
