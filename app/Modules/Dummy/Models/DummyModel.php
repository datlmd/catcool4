<?php namespace App\Modules\Dummy\Models;

use App\Models\DynaModel;

class DummyModel extends DynaModel
{

    protected $table      = 'dummy';
    protected $primaryKey = 'dummy_id';

    //protected $allowedFields = ['dummy_id', 'sort_order', 'published', 'ctime', 'mtime'];

    protected $useTimestamps = false;
    protected $createdField  = 'ctime';
    protected $updatedField  = 'mtime';

    protected $validationRules    = [];
    protected $validationMessages = [];
    //protected $skipValidation     = false;

    //protected $relationships = ['dummy_description'];

//    protected $belongsTo = [
//        'table' => 'dummy_description',
//        'primaryKey' => 'dummy_id',
//        'relationId' => 'dummy_id',
//    ];
//    protected $hasMany = [
//        'table' => 'dummy_description',
//        'primaryKey' => 'dummy_id',
//        'relationId' => 'dummy_id',
//    ];

    public function __construct()
    {
        parent::__construct();


    }

    public function get_all_by_filter($filter = null, $limit = 0, $offset = 0, $order = null)
    {

        return $this->hasMany('dummy_description', 'dummy_id')->with('dummy_description', ['name'])->findAll();

        $filter_root = [];

        if (!empty($filter["id"])) {
            $filter_root[] = ["dummy_id", (is_array($filter["id"])) ? $filter["id"] : explode(",", $filter["id"])];
        }

        if (empty($filter["language_id"])) {
            $filter["language_id"] = get_lang_id();
        }

        if (empty($filter["name"])) {
            $filter_detail = sprintf("where:language_id=%d", $filter["language_id"]);
        } else {
            $filter_name   = "%" . $filter["name"] . "%";
            $filter_detail = sprintf("where:language_id=%d and name like \"%s\"", $filter["language_id"], $filter_name);
        }

        $order = empty($order) ? ["dummy_id" => "DESC"] : $order;

        //neu filter name thi phan trang bang array
        if (empty($filter["name"])) {
            $total = $this->count_rows($filter_root);
            if (!empty($limit) && isset($offset)) {
                $this->limit($limit, $offset);
            }
        }

        $result = $this->where($filter_root)->order_by($order)->with_detail($filter_detail)->get_all();
        if (empty($result)) {
            return [false, 0];
        }

        //check neu get detail null
        foreach($result as $key => $val) {
            if (empty($val["detail"])) {
                unset($result[$key]);
                if (!empty($total)) $total--;
            }
        }

        //set lai total neu filter bang ten
        if (!empty($filter["name"])) {
            $total  = count($result);
            $result = array_slice($result, $offset, $limit);
        }

        return [$result, $total];
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
