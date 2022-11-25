<?php namespace App\Modules\Customers\Models;

use App\Models\MyModel;

class LoginSocial extends MyModel
{
    protected $table      = 'customer_login_social';
    protected $primaryKey = 'social_id';

    protected $allowedFields = [
        'social_id',
        'customer_id',
        'type',
        'access_token',
        'ctime',
        'mtime',
    ];

    function __construct()
    {
        parent::__construct();
    }
}
