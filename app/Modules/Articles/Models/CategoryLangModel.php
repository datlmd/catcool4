<?php namespace App\Modules\Articles\Models;

use App\Models\MyModel;

class CategoryLangModel extends MyModel
{
    protected $table      = 'article_category_lang';
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

    function __construct()
    {
        parent::__construct();
    }
}
