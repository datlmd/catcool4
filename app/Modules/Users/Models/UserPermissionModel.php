<?php namespace App\Modules\Users\Models;

use App\Models\MyModel;

class UserPermissionModel extends MyModel
{
    protected $table      = 'user_permissions';
    protected $primaryKey = 'user_id';

    protected $allowedFields = [
        'user_id',
        'permission_id',
    ];

    function __construct()
    {
        parent::__construct();
    }
}
