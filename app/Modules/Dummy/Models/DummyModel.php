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

    public function getAllByFilter($filter = null, $sort = 'dummy_id', $order = 'DESC')
    {
        $where = "dummy_lang.language_id=" . get_lang_id();

        if (!empty($filter["id"])) {
            $where .= " AND dummy.dummy_id=" . is_array($filter["id"]) ? $filter["id"] : explode(",", $filter["id"]);
        }

        if (!empty($filter["name"])) {
            $where .= " AND dummy.name LIKE %" . $filter["name"] . '%';
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
}
