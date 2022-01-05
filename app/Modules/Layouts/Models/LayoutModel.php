<?php namespace App\Modules\Layouts\Models;

use App\Models\MyModel;

class LayoutModel extends MyModel
{
    protected $table      = 'layout';
    protected $primaryKey = 'layout_id';

    protected $allowedFields = [
        'layout_id',
        'name',
        'description',
        
    ];

    function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? $sort : 'layout_id';
        $order = empty($order) ? 'DESC' : $order;

        if (!empty($filter["layout_id"])) {
            $this->whereIn('layout_id', (is_array($filter["layout_id"])) ? $filter["layout_id"] : explode(',', $filter["layout_id"]));
        }

        if (!empty($filter["name"])) {
            if (!empty($filter["name"])) {
                $this->Like('name', $filter["name"]);
            }
        }

        return $this->orderBy($sort, $order);
    }
}
