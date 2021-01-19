<?php namespace App\Modules\Dummy\Models;

use CodeIgniter\Model;

class DummyModel extends Model
{

    protected $table      = 'dummy';
    protected $primaryKey = 'dummy_id';

    protected $allowedFields = ['dummy_id', 'sort_order', 'published', 'ctime', 'mtime'];

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = 'dummy_id', $order = 'DESC')
    {
        $where = "dummy_description.language_id=" . get_lang_id();

        if (!empty($filter["id"])) {
            $where .= " AND dummy.dummy_id=" . is_array($filter["id"]) ? $filter["id"] : explode(",", $filter["id"]);
        }

        if (!empty($filter["name"])) {
            $where .= " AND dummy.name LIKE %" . $filter["name"] . '%';
        }

        $this->select('dummy.*, dummy_description.name AS name, dummy_description.description AS description')
            ->join('dummy_description', 'dummy_description.dummy_id = dummy.dummy_id')
            ->where($where)
            ->orderBy($sort, $order);

        return $this;
    }

    public function get_list_full_detail($ids)
    {
        if (empty($ids)) {
            return false;
        }

        $ids           = is_array($ids) ? $ids : explode(",", $ids);
        $filter_detail = sprintf("where:language_id=%d", get_lang_id());
        $result        = $this->where("dummy_id", $ids)->with_detail($filter_detail)->get_all();

        return $result;
    }
}
