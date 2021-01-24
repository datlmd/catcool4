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
        'mtime'
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $with = ['dummy_lang'];

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort_data = [
            'dummy_id',
            'name',
            'description',
            'sort_order',
        ];

        $sort  = in_array($sort, $sort_data) ? $sort : 'dummy_id';
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';


        $where = "dummy_lang.language_id=" . get_lang_id();

        if (!empty($filter["id"])) {
            $where .= " AND id IN(" . (is_array($filter["id"]) ? implode(',', $filter["id"]) : $filter["id"]) . ")";
        }

        if (!empty($filter["name"])) {
            $where .= " AND dummy.name LIKE '%" . $filter["name"] . "%'";
        }

        $this->select('dummy.*, dummy_lang.name AS name, dummy_lang.description AS description')
            ->with(false)
            ->join('dummy_lang', 'dummy_lang.dummy_id = dummy.dummy_id')
            ->where($where)
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

        $result = format_data_lang_id($result, 'dummy_lang');
        if (!empty($language_id) && !empty($result['dummy_lang'][$language_id])) {
            $result['dummy_lang'] = $result['dummy_lang'][$language_id];
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
            $result[$key] = format_data_lang_id($value, 'dummy_lang');
            if (!empty($language_id) && !empty($result[$key]['dummy_lang'][$language_id])) {
                $result[$key]['dummy_lang'] = $result[$key]['dummy_lang'][$language_id];
            }
        }

        return $result;
    }
}
