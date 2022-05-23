<?php namespace App\Modules\Products\Models;

use App\Models\MyModel;

class OrderStatusLangModel extends MyModel
{
    protected $table      = 'order_status_lang';
    protected $primaryKey = 'order_status_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'order_status_id',
        'language_id',
        'name',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
