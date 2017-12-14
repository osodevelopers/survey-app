<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{


    //Names the table
    protected $table = 'survey';

    //Shows the fields in the table that can be filled from the system
    protected $fillable = [
        'id',
        'creator_id',
        'slug',
        'title',
        'description',
        'active',
        'anonymous',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
        'anonymous' => 'boolean',
    ];
     /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        // 'saved' => UserSaved::class,
        // 'creating' => UserSaved::class,
        // 'deleted' => UserDeleted::class,
    ];

    //A survey has zero or many questions
    public function question()
    {
        return $this->hasMany('App\Question', 'id');
    }

    //A survey belongs to one user
    public function user()
    {
        return $this->belongsTo('App\User', 'creator_id');
    }


}
