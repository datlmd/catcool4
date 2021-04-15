<?php namespace App\Modules\Dummy\Models;

use App\Models\MyModel;

class DummyModel extends MyModel
{
    protected $table      = 'dummy';
    protected $primaryKey = 'dummy_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'dummy_id',
        'sort_order',
        'published',
        'ctime',
        'mtime',
        //FIELD_ROOT
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $table_lang = 'dummy_lang';
    protected $with = ['dummy_lang'];

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : "");
        $sort  = !empty($sort) ? $sort : "$this->table.dummy_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';


        $this->where("$this->table_lang.language_id", get_lang_id(true));
        if (!empty($filter["dummy_id"])) {
            $this->whereIn("$this->table.dummy_id", (!is_array($filter["dummy_id"]) ? explode(',', $filter["dummy_id"]) : $filter["dummy_id"]));
        }

        if (!empty($filter["name"])) {
            $this->like("$this->table_lang.name", $filter["name"]);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->with(false)
            ->join($this->table_lang, "$this->table_lang.dummy_id = $this->table.dummy_id")
            ->orderBy($sort, $order);

        return $this;
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

        $result = format_data_lang_id($result, $this->table_lang);
        if (!empty($language_id) && !empty($result[$this->table_lang][$language_id])) {
            $result[$this->table_lang] = $result[$this->table_lang][$language_id];
        }

        return $result;
    }

    public function getListDetail($ids, $language_id = null)
    {
        if (empty($ids)) {
            return null;
        }

        $result = $this->find($ids);
        if (empty($result)) {
            return null;
        }

        foreach ($result as $key => $value) {
            $result[$key] = format_data_lang_id($value, $this->table_lang);
            if (!empty($language_id) && !empty($result[$key][$this->table_lang][$language_id])) {
                $result[$key][$this->table_lang] = $result[$key][$this->table_lang][$language_id];
            }
        }

        return $result;
    }
}
