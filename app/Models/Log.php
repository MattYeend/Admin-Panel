<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Log extends Model
{
    protected $table = 'logs';

    protected $fillable = [
        'action_id',
        'data',
        'logged_in_user_id',
        'related_to_user_id',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function loggedInUser()
    {
        return $this->belongsTo(User::class, 'logged_in_user_id');
    }

    public function relatedToUser()
    {
        return $this->belongsTo(User::class, 'related_to_user_id');
    }

    const ACTION_LOGIN = 1;
    const ACTION_LOGOUT = 2;
    const ACTION_CREATE_USER = 3;
    const ACTION_UPDATE_USER = 4;
    const ACTION_DELETE_USER = 5;
    const ACTION_SHOW_USER = 6;
    const ACTION_WELCOME_EMAIL_SENT = 7;
    const ACTION_CONFIRM_PASSWORD = 8;
    const ACTION_FORGOT_PASSWORD = 9;
    const ACTION_REGISTER_USER = 10;
    const ACTION_LOGIN_FAILED = 11;
    const ACTION_LOGIN_PASSWORD_FAILED = 12;
    const ACTION_LOGIN_EMAIL_FAILED = 13;
    const ACTION_LOGIN_USERNAME_FAILED = 14;
    const ACTION_LOGIN_SUCCESS = 15;
    const ACTION_RESET_PASSWORD = 16;
    const ACTION_RESET_EMAIL = 17;
    const ACTION_RESET_USERNAME = 18;
    const ACTION_VERIFY_USER = 19;
    const ACTION_PASSWORD_CHANGED = 20;
    const ACTION_MFA_ENABLED = 21;
    const ACTION_MFA_DISABLED = 22;
    const ACTION_PROFILE_UPDATED = 23;
    const ACTION_EMAIL_UPDATED = 24;
    const ACTION_ROLE_ASSIGNED = 25;
    const ACTION_PERMISSION_GRANTED = 26;
    const ACTION_PERMISSION_REVOKED = 27;
    const ACTION_GENERAL_ERROR = 28;
    const ACTION_FOUR_HUNDRED_ERROR = 29;
    const ACTION_FIVE_HUNDRED_ERRORS = 30;
    const ACTION_CLEAR_CACHE = 31;

    public static function log($action = 0, $data = null, $logged_in_user_id = null, $related_to_user_id = null)
    {
        if (isset($action)) {
            $logged_in_user_id = $logged_in_user_id ?? Auth::id();

            if (is_array($data)) {
                $data = json_encode($data);
            } elseif (!is_null($data)) {
                throw new \InvalidArgumentException('Data must be an array or null.');
            }

            $log = new self();
            $log->logged_in_user_id = $logged_in_user_id;
            $log->action_id = $action;
            $log->related_to_user_id = $related_to_user_id;
            $log->data = $data;
            $log->save();
        }
    }
}
