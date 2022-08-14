<?php namespace App\Modules\Products\Models;

use App\Models\MyModel;

class ProductLangModel extends MyModel
{
    protected $table      = 'product_lang';
    protected $primaryKey = 'product_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'product_id',
        'language_id',
        'name',
        'slug',
        'description',
        'tag',
        'meta_title',
        'meta_description',
        'meta_keyword',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
