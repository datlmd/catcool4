<?php

namespace App\Modules\Pages\Models;

use App\Models\MyModel;

class PageLangModel extends MyModel
{
    protected $table      = 'page_lang';
    protected $primaryKey = 'page_id';

    protected $allowedFields = [
        'page_id',
        'language_id',
        'name',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'meta_keyword',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
