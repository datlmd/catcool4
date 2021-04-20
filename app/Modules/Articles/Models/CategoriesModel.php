<?php namespace App\Modules\Articles\Models;

use App\Models\MyModel;

class CategoriesModel extends MyModel
{
    protected $table      = 'article_categories';
    protected $primaryKey = 'article_id';

    protected $allowedFields = [
        'article_id',
        'category_id',
    ];

    function __construct()
    {
        parent::__construct();
    }
}
