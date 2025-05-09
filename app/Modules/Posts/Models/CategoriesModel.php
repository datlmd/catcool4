<?php

namespace App\Modules\Posts\Models;

use App\Models\MyModel;

class CategoriesModel extends MyModel
{
    protected $table      = 'post_categories';
    protected $primaryKey = 'post_id';

    protected $allowedFields = [
        'post_id',
        'category_id',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
