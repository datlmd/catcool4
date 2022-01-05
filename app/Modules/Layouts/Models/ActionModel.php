<?php namespace App\Modules\Layouts\Models;

use App\Models\MyModel;

class ActionModel extends MyModel
{
    protected $table      = 'layout_action';
    protected $primaryKey = 'layout_action_id';

    protected $allowedFields = [
        'layout_action_id',
        'name',
        'controller',
        'action',
    ];

    function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? $sort : 'layout_action_id';
        $order = empty($order) ? 'DESC' : $order;

        if (!empty($filter["layout_action_id"])) {
            $this->whereIn('layout_action_id', (is_array($filter["layout_action_id"])) ? $filter["layout_action_id"] : explode(',', $filter["layout_action_id"]));
        }

        if (!empty($filter["name"])) {
            if (!empty($filter["name"])) {
                $this->Like('name', $filter["name"]);
            }
        }

        return $this->orderBy($sort, $order);
    }
}
