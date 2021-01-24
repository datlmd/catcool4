<?php namespace App\Modules\Permissions\Models;

use App\Models\MyModel;

class PermissionModel extends MyModel
{
    protected $table      = 'permission';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id',
        'name',
        'description',
        'published',
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

        $this->orderBy($sort, $order);

        return $this;
    }

    public function getListPublished()
    {
        $result = $this->where('published =' . STATUS_ON)->findAll();
        if (empty($result)) {
            return null;
        }

        return $result;
    }
}
