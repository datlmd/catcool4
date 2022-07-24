<?php namespace App\Modules\Options\Models;

use App\Models\MyModel;

class OptionLangModel extends MyModel
{
    protected $table      = 'option_lang';
    protected $primaryKey = 'option_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'option_id',
        'language_id',
        'name',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
