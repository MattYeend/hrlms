<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Log extends Model
{
    // Log in/out
    public const ACTION_LOGIN = 1;
    public const ACTION_LOGOUT = 2;

    // User logs
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

    // Login logs
    public const ACTION_LOGIN_FAILED = 14;
    public const ACTION_LOGIN_PASSWORD_FAILED = 15;
    public const ACTION_LOGIN_EMAIL_FAILED = 16;
    public const ACTION_LOGIN_USERNAME_FAILED = 17;
    public const ACTION_LOGIN_SUCCESS = 18;

    // Reset logs
    public const ACTION_RESET_PASSWORD = 19;
    public const ACTION_RESET_EMAIL = 20;
    public const ACTION_RESET_USERNAME = 21;

    // Verify user
    public const ACTION_VERIFY_USER = 22;

    // Password change
    public const ACTION_PASSWORD_CHANGED = 23;

    // MFA (multi-factor authentication)
    public const ACTION_MFA_ENABLED = 24;
    public const ACTION_MFA_DISABLED = 25;

    // Profile logs
    public const ACTION_PROFILE_UPDATED = 26;
    public const ACTION_PROFILE_DELETED = 27;

    // Update email
    public const ACTION_EMAIL_UPDATED = 28;

    // Assign role
    public const ACTION_ROLE_ASSIGNED = 29;

    // Permission logs
    public const ACTION_PERMISSION_GRANTED = 30;
    public const ACTION_PERMISSION_REVOKED = 31;

    // Error logs
    public const ACTION_GENERAL_ERROR = 32;
    public const ACTION_FOUR_HUNDRED_ERROR = 33;
    public const ACTION_FOUR_ZERO_THREE_ERROR = 34;
    public const ACTION_FOUR_ZERO_FOUR_ERROR = 35;
    public const ACTION_FOUR_ONE_NINE_ERROR = 36;
    public const ACTION_FOUR_TWO_NINE_ERROR = 37;
    public const ACTION_FIVE_HUNDRED_ERROR = 38;
    public const ACTION_FIVE_ZERO_THREE_ERROR = 39;

    // Clear cache
    public const ACTION_CLEAR_CACHE = 40;

    // Department logs
    public const ACTION_CREATE_DEPARTMENT = 41;
    public const ACTION_UPDATE_DEPARTMENT = 42;
    public const ACTION_DELETE_DEPARTMENT = 43;
    public const ACTION_VIEW_DEPARTMENTS = 44;
    public const ACTION_SHOW_DEPARTMENT = 45;
    public const ACTION_REINSTATE_DEPARTMENT = 46;

    // Role logs
    public const ACTION_VIEW_ROLES = 47;
    public const ACTION_SHOW_ROLE = 48;

    // Authentication/email verification logs
    public const ACTION_AUTHENTICATE_SESSION_CREATE = 49;
    public const ACTION_AUTHENTICATE_SESSION_DESTROY = 50;
    public const ACTION_EMAIL_VERIFICATION_NOTIFICATION = 51;
    public const ACTION_EMAIL_VERIFICATION = 52;

    // View archived
    public const ACTION_VIEW_ARCHIVED_USERS = 53;
    public const ACTION_VIEW_ARCHIVED_DEPARTMENTS = 54;

    // Job logs
    public const ACTION_VIEW_JOBS = 55;
    public const ACTION_SHOW_JOB = 56;
    public const ACTION_CREATE_JOB = 57;
    public const ACTION_UPDATE_JOB = 58;
    public const ACTION_DELETE_JOB = 59;
    public const ACTION_REINSTATE_JOB = 60;
    public const ACTION_VIEW_ARCHIVED_JOBS = 61;

    // Blog logs
    public const ACTION_VIEW_BLOGS = 62;
    public const ACTION_SHOW_BLOG = 63;
    public const ACTION_CREATE_BLOG = 64;
    public const ACTION_UPDATE_BLOG = 65;
    public const ACTION_DELETE_BLOG = 66;
    public const ACTION_REINSTATE_BLOG = 67;
    public const ACTION_VIEW_ARCHIVED_BLOGS = 68;
    public const ACTION_LIKED_BLOG = 69;
    public const ACTION_UNLIKED_BLOG = 70;
    public const ACTION_COMMENTED_ON_BLOG = 71;
    public const ACTION_UNCOMMENTED_ON_BLOG = 72;
    public const ACTION_UPDATE_COMMENT_ON_BLOG = 73;
    public const ACTION_REINSTATE_COMMENT_ON_BLOG = 74;
    public const ACTION_APPROVE_BLOG = 75;
    public const ACTION_DENY_BLOG = 76;
    public const ACTION_VIEW_DENIED_BLOGS = 77;

    // Learning Provider logs
    public const ACTION_VIEW_LEARNING_PROVIDERS = 78;
    public const ACTION_SHOW_LEARNING_PROVIDER = 79;
    public const ACTION_CREATE_LEARNING_PROVIDER = 80;
    public const ACTION_UPDATE_LEARNING_PROVIDER = 81;
    public const ACTION_DELETE_LEARNING_PROVIDER = 82;
    public const ACTION_REINSTATE_LEARNING_PROVIDER = 83;
    public const ACTION_VIEW_ARCHIVED_LEARNING_PROVIDERS = 84;

    // Business Type logs
    public const ACTION_VIEW_BUSINESS_TYPES = 85;
    public const ACTION_SHOW_BUSINESS_TYPE = 86;
    public const ACTION_CREATE_BUSINESS_TYPE = 87;
    public const ACTION_UPDATE_BUSINESS_TYPE = 88;
    public const ACTION_DELETE_BUSINESS_TYPE = 89;
    public const ACTION_REINSTATE_BUSINESS_TYPE = 90;
    public const ACTION_VIEW_ARCHIVED_BUSINESS_TYPES = 91;

    // Quizz logs
    public const ACTION_VIEW_QUIZZES = 92;
    public const ACTION_SHOW_QUIZ = 93;
    public const ACTION_CREATE_QUIZ = 94;
    public const ACTION_UPDATE_QUIZ = 95;
    public const ACTION_DELETE_QUIZ = 96;
    public const ACTION_REINSTATE_QUIZ = 97;
    public const ACTION_VIEW_ARCHIVED_QUIZZES = 98;

    protected $table = 'logs';

    protected $fillable = [
        'action_id',
        'data',
        'logged_in_user_id',
        'related_to_user_id',
    ];

    protected $casts = [
        'data' => 'string',
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
