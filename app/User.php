<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

use App\Question;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Route notifications for the mail channel.
     *
     * @return string
     */
    public function routeNotificationForMail()
    {
        return $this->email;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function votes() {
        return $this->hasMany('App\Vote');
    }

    // Needs mysql 5.7
    // Would allow to check past notifications
    public static function get_meta($question_id) {
        $notifications = DB::table('notifications')
            ->where('data->question_id', '=', $question_id)
            ->get();
        return $notifications;
    }

/*
    public static function get_participation($user_id) {
        $questions = Question::select(['questions.*'])
            ->join('answers', 'questions.user_id', '=', 'answers.user_id')
            ->where([
                ['questions.user_id', '=', $user_id],
                ['answers.user_id', '=', $user_id],
            ])
            ->groupby('questions.question')
            ->paginate(10);
        return $questions;
    }*/
}
