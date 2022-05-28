<?php namespace App\Modules\Manufacturers\Models;

use App\Models\MyModel;

class ManufacturerLangModel extends MyModel
{
    protected $table      = 'manufacturer_lang';
    protected $primaryKey = 'manufacturer_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        "manufacturer_id",
        "language_id",
        "name",
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
