<?php namespace App\Modules\UsersAdmin\Models;

use App\Models\MyModel;

class UserGroupModel extends MyModel
{
    protected $table      = 'user_admin_groups';
    protected $primaryKey = 'user_id';

    protected $allowedFields = [
        'user_id',
        'group_id',
    ];

    function __construct()
    {
        parent::__construct();
    }
}
