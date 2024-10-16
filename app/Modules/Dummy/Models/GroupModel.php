<?php namespace App\Modules\Dummy\Models;

use App\Models\MyModel;

class GroupModel extends MyModel
{
    protected $table      = 'dummy_group';
    protected $primaryKey = 'dummy_id';

    protected $allowedFields = [
        "dummy_id",
        "name",
        "description",
        //FIELD_ROOT
    ];

    function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? $sort : 'dummy_id';
        $order = empty($order) ? 'DESC' : $order;

        if (!empty($filter["dummy_id"])) {
            $this->whereIn('dummy_id', (is_array($filter["dummy_id"])) ? $filter["dummy_id"] : explode(',', $filter["dummy_id"]));
        }

        if (!empty($filter["name"])) {
            if (!empty($filter["name"])) {
                $this->like('name', $filter["name"]);
            }
        }

        return $this->orderBy($sort, $order);
    }
}
