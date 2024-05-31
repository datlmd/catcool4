<?php

namespace App\Models;

use CodeIgniter\Model;

class MyModel extends Model
{
    //use \Tatter\Relations\Traits\ModelTrait;

    protected $returnType = 'array';

    protected $table_lang = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function formatDataLanguage($data, $language_id)
    {
        if (empty($data)) {
            return [];
        }

        $list = [];
        foreach ($data as $value) {
            if (!isset($value['language_id'])) {
                continue;
            }
            if ($value['language_id'] == $language_id) {
                $list[$value[$this->primaryKey]] = isset($list[$value[$this->primaryKey]]) ? array_merge($list[$value[$this->primaryKey]], $value) : $value;
            }
            $list[$value[$this->primaryKey]]['lang'][$value['language_id']] = $value;
        }

        return $list;
    }

    public function showSQL(\CodeIgniter\Model $model)
    {
        if (empty($model)) {
            return null;
        }

        $builder = $model->builder();

        return $builder->getCompiledSelect();
    }
}
