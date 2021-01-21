<?php namespace App\Modules\Dummy\Models;

use App\Models\MyModel;

class DummyLangModel extends MyModel
{
    protected $table      = 'dummy_lang';
    protected $primaryKey = 'dummy_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'dummy_id',
        'language_id',
        'name',
        'description'
    ];

    protected $with = ['dummy'];

    public function __construct()
    {
        parent::__construct();
    }
}
