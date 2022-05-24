<?php namespace App\Modules\Returns\Models;

use App\Models\MyModel;

class ActionLangModel extends MyModel
{
    protected $table      = 'return_action_lang';
    protected $primaryKey = 'return_action_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'return_action_id',
        'language_id',
        'name',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
