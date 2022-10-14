<?php namespace App\Modules\Users\Models;

use App\Models\MyModel;

class UserGroupLangModel extends MyModel
{
    protected $table      = 'user_group_lang';
    protected $primaryKey = 'user_group_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'user_group_id',
        'language_id',
        'name',
        "description",
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
