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
    public const ACTION_NEW_PASSWORD = 12;
    public const ACTION_REGISTER_USER = 13;
    public const ACTION_LOGIN_FAILED = 14;
    public const ACTION_LOGIN_PASSWORD_FAILED = 15;
    public const ACTION_LOGIN_EMAIL_FAILED = 16;
    public const ACTION_LOGIN_USERNAME_FAILED = 17;
    public const ACTION_LOGIN_SUCCESS = 18;
    public const ACTION_RESET_PASSWORD = 19;
    public const ACTION_RESET_EMAIL = 20;
    public const ACTION_RESET_USERNAME = 21;
    public const ACTION_VERIFY_USER = 22;
    public const ACTION_PASSWORD_CHANGED = 23;
    public const ACTION_MFA_ENABLED = 24;
    public const ACTION_MFA_DISABLED = 25;
    public const ACTION_PROFILE_UPDATED = 26;
    public const ACTION_PROFILE_DELETED = 27;
    public const ACTION_EMAIL_UPDATED = 28;
    public const ACTION_ROLE_ASSIGNED = 29;
    public const ACTION_PERMISSION_GRANTED = 30;
    public const ACTION_PERMISSION_REVOKED = 31;
    public const ACTION_GENERAL_ERROR = 32;
    public const ACTION_FOUR_HUNDRED_ERROR = 33;
    public const ACTION_FOUR_ZERO_THREE_ERROR = 34;
    public const ACTION_FOUR_ZERO_FOUR_ERROR = 35;
    public const ACTION_FOUR_ONE_NINE_ERROR = 36;
    public const ACTION_FOUR_TWO_NINE_ERROR = 37;
    public const ACTION_FIVE_HUNDRED_ERROR = 38;
    public const ACTION_FIVE_ZERO_THREE_ERROR = 39;
    public const ACTION_CLEAR_CACHE = 40;
    public const ACTION_CREATE_DEPARTMENT = 41;
    public const ACTION_UPDATE_DEPARTMENT = 42;
    public const ACTION_DELETE_DEPARTMENT = 43;
    public const ACTION_VIEW_DEPARTMENTS = 44;
    public const ACTION_SHOW_DEPARTMENT = 45;
    public const ACTION_REINSTATE_DEPARTMENT = 46;
    public const ACTION_VIEW_ROLES = 47;
    public const ACTION_SHOW_ROLE = 48;
    public const ACTION_CREATE_COMPANY = 49;
    public const ACTION_UPDATE_COMPANY = 50;
    public const ACTION_DELETE_COMPANY = 51;
    public const ACTION_VIEW_COMPANIES = 52;
    public const ACTION_SHOW_COMPANY = 53;
    public const ACTION_REINSTATE_COMPANY = 54;
    public const ACTION_AUTHENTICATE_SESSION_CREATE = 55;
    public const ACTION_AUTHENTICATE_SESSION_DESTROY = 56;
    public const ACTION_EMAIL_VERIFICATION_NOTIFICATION = 57;
    public const ACTION_EMAIL_VERIFICATION = 58;
    public const ACTION_VIEW_ARCHIVED_USERS = 59;
    public const ACTION_VIEW_ARCHIVED_DEPARTMENTS = 60;
    public const ACTION_VIEW_ARCHIVED_COMPANIES = 61;
    public const ACTION_VIEW_JOBS = 62;
    public const ACTION_SHOW_JOB = 63;
    public const ACTION_CREATE_JOB = 64;
    public const ACTION_UPDATE_JOB = 65;
    public const ACTION_DELETE_JOB = 66;
    public const ACTION_REINSTATE_JOB = 67;
    public const ACTION_VIEW_ARCHIVED_JOBS = 68;

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
