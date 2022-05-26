<?php namespace App\Modules\Attributes\Models;

use App\Models\MyModel;

class AttributeLangModel extends MyModel
{
    protected $table      = 'attribute_lang';
    protected $primaryKey = 'attribute_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'attribute_id',
        'language_id',
        'name',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
