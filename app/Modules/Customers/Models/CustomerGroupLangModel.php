<?php namespace App\Modules\Customers\Models;

use App\Models\MyModel;

class CustomerGroupLangModel extends MyModel
{
    protected $table      = 'customer_group_lang';
    protected $primaryKey = 'customer_group_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'customer_group_id',
        'language_id',
        'name',
        "description",
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
