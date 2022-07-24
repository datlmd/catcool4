<?php namespace App\Modules\Options\Models;

use App\Models\MyModel;

class OptionValueLangModel extends MyModel
{
    protected $table      = 'option_value_lang';
    protected $primaryKey = 'option_value_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'option_value_id',
        'language_id',
        'option_id',
        'name',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
