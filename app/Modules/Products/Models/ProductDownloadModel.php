<?php namespace App\Modules\Products\Models;

use App\Models\MyModel;

class ProductDownloadModel extends MyModel
{
    protected $table      = 'product_download';
    protected $primaryKey = 'product_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'product_id',
        'download_id',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
