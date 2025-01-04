<?php

namespace MattYeend\Logger\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Logger extends Model
{
    protected $table = 'logger';

    protected $fillable = [
        'action_id',
        'data',
        'logged_in_user_id',
        'related_to_user_id'
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function loggedInUser(){
        return $this->belongsTo(User::class, 'logged_in_user_id');
    }

    public function relatedToUser(){
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
    const ACTION_RESET_PASSWORD = 11;
    const ACTION_VERIFY_USER = 12;
    const ACTION_PASSWORD_CHANGED = 13;
    const ACTION_MFA_ENABLED = 14;
    const ACTION_MFA_DISABLED = 15;
    const ACTION_PROFILE_UPDATED = 16;
    const ACTION_EMAIL_UPDATED = 17;
    const ACTION_ROLE_ASSIGNED = 18;
    const ACTION_PERMISSION_GRANTED = 19;
    const ACTION_PERMISSION_REVOKED = 20;
    const ACTION_GENERAL_ERROR = 21;
    const ACTION_FOUR_HUNDRED_ERROR = 22;
    const ACTION_FIVE_HUNDRED_ERRORS = 23;
    const ACTION_CLEAR_CACHE = 24;

    /* Add your own actions below by using a similar format to above (const ACTION_NAME_OF_ACTION = ###).
     * To keep with naming conventions, the constant key word should be lower case, and the action should
     * all be upper case starting with the word 'ACTION_'
     */

    // Your actions to go below here. 

    /* Put temporary actions below here.
     * Put new actions below before submitting for code review and move up when merging to make sure all
     * ID's aren't already used. 
     * Ensure that the naming conventions match and everything after 'ACTION_ is relevant to the task at 
     * hand. 
     */

    // Not an action, do not use
    const NOT_AN_ACTION = 000;

    public static function log($action = 0, $data = null, $logged_in_user_id = null, $related_to_user_id = null){
        if(isset($action)){
            if(empty($logged_in_user_id)){
                $logged_in_user_id = Auth::user()->id;
            }
            if(in_array(gettype($data), ['array'])){
                $data = json_encode($data);
            }else{
                throw new \InvalidArgumentException('Data must be an array or null.');
            }

            $log = new Logger;
            $log->logged_in_user_id = $logged_in_user_id;
            $log->action_id = $action;
            $log->related_to_user_id = $related_to_user_id;
            $log->data = $data;
            $log->save();
        }
    }
}