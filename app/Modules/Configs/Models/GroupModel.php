<?php namespace App\Modules\Configs\Models;

use App\Models\MyModel;

class GroupModel extends MyModel
{
    protected $table      = 'config_group';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id',
        'name',
        'description',
    ];

    function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = empty($sort) ? 'id' : $sort;
        $order = empty($order) ? 'DESC' : $order;
        $where = null;

        if (!empty($filter["id"])) {
            $where .= "id IN(" . (is_array($filter["id"]) ? implode(',', $filter["id"]) : $filter["id"]) . ")";
        }

        if (!empty($filter["name"])) {
            $where .= empty($where) ? "" : " AND ";
            $where .= "(name LIKE '%" . $filter["name"] . "%' OR description LIKE '%" . $filter["name"] . "%')";
        }

        if (!empty($where)) {
            $this->where($where);
        }

        return $this->orderBy($sort, $order)->findAll();
    }
}
