<?php namespace App\Modules\Users\Models;

use App\Models\MyModel;

class UserLoginSocial extends MyModel
{
    protected $table      = 'user_login_social';
    protected $primaryKey = 'social_id';

    protected $allowedFields = [
        'social_id',
        'user_id',
        'type',
        'ctime',
        'mtime',
    ];

    function __construct()
    {
        parent::__construct();
    }
}
