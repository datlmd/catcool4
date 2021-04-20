<?php namespace App\Modules\Articles\Models;

use App\Models\MyModel;

class ArticleLangModel extends MyModel
{
    protected $table      = 'article_lang';
    protected $primaryKey = 'article_id';

    protected $allowedFields = [
        'article_id',
        'language_id',
        'name',
        'slug',
        'description',
        'content',
        'meta_title',
        'meta_description',
        'meta_keyword',
    ];

    function __construct()
    {
        parent::__construct();
    }
}
