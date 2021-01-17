<?php namespace App\Modules\Dummy\Models;

use App\Models\DynaModel;

class DummyDescriptionModel extends DynaModel
{
    protected $relationships = ['dummy'];

    function __construct()
    {
        parent::__construct();

        $this->table = 'dummy_description';
        $this->primaryKey = 'dummy_id';

        $this->fieldInfo = [
            "dummy_id",
            "language_id",
            "name",
            "description",
            //FIELD_DESCRIPTION
        ];



    }
}
