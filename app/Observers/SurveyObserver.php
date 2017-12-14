<?php

namespace App\Observers;

use App\Models\Survey;
use Illuminate\Support\Facades\Auth;

class SurveyObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(Survey $survey)
    {
        //
    }

    /**
     * Listen to the User deleting event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleting(Survey $survey)
    {
        //
    }

    /**
     * Listen to the User deleting event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function creating(Survey $survey)
    {
        // dd(Auth::id());
        $survey->slug = str_slug($survey->title);
    }
}