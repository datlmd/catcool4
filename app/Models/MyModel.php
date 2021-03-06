<?php namespace App\Models;

use CodeIgniter\Model;

class MyModel extends Model
{
    use \Tatter\Relations\Traits\ModelTrait;

    protected $table_lang;

    public function __construct()
    {
        parent::__construct();
    }

    public function getDetail($id, $language_id = null)
    {
        if (empty($id) || !is_numeric($id)) {
            return null;
        }

        $result = $this->find($id);
        if (empty($result)) {
            return null;
        }
        $result = format_data_lang_id($result, $this->table_lang, $language_id);

        return $result;
    }

    public function getListDetail($ids, $language_id = null)
    {
        if (empty($ids)) {
            return null;
        }

        $ids    = (is_array($ids)) ? $ids : explode(",", $ids);
        $result = $this->find($ids);
        if (empty($result)) {
            return null;
        }

        foreach ($result as $key => $value) {
            $result[$key] = format_data_lang_id($value, $this->table_lang, $language_id);
        }

        return $result;
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
