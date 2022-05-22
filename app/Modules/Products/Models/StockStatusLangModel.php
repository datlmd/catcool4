<?php namespace App\Modules\Products\Models;

use App\Models\MyModel;

class StockStatusLangModel extends MyModel
{
    protected $table      = 'stock_status_lang';
    protected $primaryKey = 'stock_status_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'stock_status_id',
        'language_id',
        'name',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
