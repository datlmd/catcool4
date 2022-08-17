<?php namespace App\Modules\Products\Models;

use App\Models\MyModel;

class ProductRelatedModel extends MyModel
{
    protected $table      = 'product_related';
    protected $primaryKey = 'product_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'product_id',
        'related_id',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
