<?php namespace App\Modules\Returns\Models;

use App\Models\MyModel;

class ReasonLangModel extends MyModel
{
    protected $table      = 'return_reason_lang';
    protected $primaryKey = 'return_reason_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'return_reason_id',
        'language_id',
        'name',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
