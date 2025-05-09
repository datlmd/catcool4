<?php

namespace App\Modules\Menus\Models;

use App\Models\MyModel;

class MenuLangModel extends MyModel
{
    protected $table      = 'menu_lang';
    protected $primaryKey = 'menu_id';

    protected $allowedFields = [
        'menu_id',
        'language_id',
        'name',
        'description',
        'slug'
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
