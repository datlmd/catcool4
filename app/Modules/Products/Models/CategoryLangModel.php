<?php

namespace App\Modules\Products\Models;

use App\Models\MyModel;

class CategoryLangModel extends MyModel
{
    protected $table      = 'product_category_lang';
    protected $primaryKey = 'category_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        "category_id",
        "language_id",
        "name",
        "description",
        "slug",
        "meta_title",
        "meta_description",
        "meta_keyword",
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
