<?php

namespace App\Modules\Categories\Models;

use App\Models\MyModel;

class CategoryLangModel extends MyModel
{
    protected $table      = 'category_lang';
    protected $primaryKey = 'category_id';

    protected $allowedFields = [
        'category_id',
        'language_id',
        'name',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'meta_keyword',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
