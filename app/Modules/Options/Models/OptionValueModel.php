<?php namespace App\Modules\Options\Models;

use App\Models\MyModel;

class OptionValueModel extends MyModel
{
    protected $table      = 'option_value';
    protected $primaryKey = 'option_value_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'option_value_id',
        'option_id',
        'image',
        'sort_order'
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $table_lang = 'option_value_lang';
    protected $with = ['option_value_lang'];

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : "");
        $sort  = !empty($sort) ? $sort : "$this->table.option_value_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", get_lang_id(true));
        if (!empty($filter["option_value_id"])) {
            $this->whereIn("$this->table.option_value_id", (!is_array($filter["option_value_id"]) ? explode(',', $filter["option_value_id"]) : $filter["option_value_id"]));
        }

        if (!empty($filter["name"])) {
            $this->like("$this->table_lang.name", $filter["name"]);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->with(false)
            ->join($this->table_lang, "$this->table_lang.option_value_id = $this->table.option_value_id")
            ->orderBy($sort, $order);

        return $this;
    }

    public function getListByOptionId($option_id)
    {
        $result = $this->orderBy('sort_order', 'DESC')->where('option_id', $option_id)->findAll();
        if (empty($result)) {
            return [];
        }

        $language_id = get_lang_id(IS_ADMIN);
        foreach ($result as $key => $value) {
            $result[$key] = format_data_lang_id($value, $this->table_lang, $language_id);
        }

        return $result;
    }
}
