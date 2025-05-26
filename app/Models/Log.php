<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Log extends Model
{
    public const ACTION_LOGIN = 1;
    public const ACTION_LOGOUT = 2;
    public const ACTION_CREATE_USER = 3;
    public const ACTION_UPDATE_USER = 4;
    public const ACTION_DELETE_USER = 5;
    public const ACTION_VIEW_USERS = 6;
    public const ACTION_SHOW_USER = 7;
    public const ACTION_REINSTATE_USER = 8;
    public const ACTION_WELCOME_EMAIL_SENT = 9;
    public const ACTION_CONFIRM_PASSWORD = 10;
    public const ACTION_FORGOT_PASSWORD = 11;
    public const ACTION_REGISTER_USER = 12;
    public const ACTION_LOGIN_FAILED = 13;
    public const ACTION_LOGIN_PASSWORD_FAILED = 14;
    public const ACTION_LOGIN_EMAIL_FAILED = 15;
    public const ACTION_LOGIN_USERNAME_FAILED = 16;
    public const ACTION_LOGIN_SUCCESS = 17;
    public const ACTION_RESET_PASSWORD = 18;
    public const ACTION_RESET_EMAIL = 19;
    public const ACTION_RESET_USERNAME = 20;
    public const ACTION_VERIFY_USER = 21;
    public const ACTION_PASSWORD_CHANGED = 22;
    public const ACTION_MFA_ENABLED = 23;
    public const ACTION_MFA_DISABLED = 24;
    public const ACTION_PROFILE_UPDATED = 25;
    public const ACTION_EMAIL_UPDATED = 26;
    public const ACTION_ROLE_ASSIGNED = 27;
    public const ACTION_PERMISSION_GRANTED = 28;
    public const ACTION_PERMISSION_REVOKED = 29;
    public const ACTION_GENERAL_ERROR = 30;
    public const ACTION_FOUR_HUNDRED_ERROR = 31;
    public const ACTION_FOUR_ZERO_THREE_ERROR = 32;
    public const ACTION_FOUR_ZERO_FOUR_ERROR = 33;
    public const ACTION_FOUR_ONE_NINE_ERROR = 34;
    public const ACTION_FOUR_TWO_NINE_ERROR = 35;
    public const ACTION_FIVE_HUNDRED_ERROR = 36;
    public const ACTION_FIVE_ZERO_THREE_ERROR = 37;
    public const ACTION_CLEAR_CACHE = 38;
    public const ACTION_CREATE_DEPARTMENT = 39;
    public const ACTION_UPDATE_DEPARTMENT = 40;
    public const ACTION_DELETE_DEPARTMENT = 41;
    public const ACTION_VIEW_DEPARTMENTS = 42;
    public const ACTION_SHOW_DEPARTMENT = 43;
    public const ACTION_REINSTATE_DEPARTMENT = 44;
    public const ACTION_VIEW_ROLES = 45;
    public const ACTION_SHOW_ROLE = 46;
    public const ACTION_CREATE_COMPANY = 47;
    public const ACTION_UPDATE_COMPANY = 48;
    public const ACTION_DELETE_COMPANY = 49;
    public const ACTION_VIEW_COMPANIES = 50;
    public const ACTION_SHOW_COMPANY = 51;
    public const ACTION_REINSTATE_COMPANY = 52;

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

    public static function log(
        $action = 0,
        $data = null,
        $logged_in_user_id = null,
        $related_to_user_id = null
    ) {
        if (isset($action)) {
            $logged_in_user_id = $logged_in_user_id ?? Auth::id();

            if (is_array($data)) {
                $data = json_encode($data);
            } elseif (! is_null($data)) {
                throw new \InvalidArgumentException(
                    'Data must be an array or null.'
                );
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
