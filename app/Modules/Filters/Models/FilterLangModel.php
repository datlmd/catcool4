<?php namespace App\Modules\Filters\Models;

use App\Models\MyModel;

class FilterLangModel extends MyModel
{
    protected $table      = 'filter_lang';
    protected $primaryKey = 'filter_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'filter_id',
        'language_id',
        'filter_group_id',
        'name',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
