<?php

namespace App\Modules\Attributes\Models;

use App\Models\MyModel;

class GroupModel extends MyModel
{
    protected $table = 'attribute_group';
    protected $primaryKey = 'attribute_group_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'attribute_group_id',
        'sort_order',
    ];

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $table_lang = 'attribute_group_lang';

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : '');
        $sort = !empty($sort) ? $sort : "$this->table.attribute_group_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", language_id_admin());
        if (!empty($filter['attribute_group_id'])) {
            $this->whereIn("$this->table.attribute_group_id", (!is_array($filter['attribute_group_id']) ? explode(',', $filter['attribute_group_id']) : $filter['attribute_group_id']));
        }

        if (!empty($filter['name'])) {
            $this->like("$this->table_lang.name", $filter['name']);
        }

        $result = $this->select("$this->table.*, $this->table_lang.*")
            ->join($this->table_lang, "$this->table_lang.attribute_group_id = $this->table.attribute_group_id")
            ->orderBy($sort, $order)->findAll();
        if (empty($result)) {
            return [];
        }

        return $result;
    }

    public function getAttributeGroupsByIds(array $attribute_group_ids, int $language_id): array
    {
        $result = $this->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
                ->orderBy('sort_order', 'DESC')
                ->where(["$this->table_lang.language_id" => $language_id])
                ->whereIn("$this->table.$this->primaryKey", $attribute_group_ids)
                ->findAll();

        return $result;
    }

    public function getAttributeGroups($language_id)
    {
        $result = $this->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
            ->where(["$this->table_lang.language_id" => $language_id])
            ->orderBy('sort_order', 'DESC')
            ->findAll();
        if (empty($result)) {
            return [];
        }

        return $result;
    }
}
