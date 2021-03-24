<?php namespace App\Modules\Relationships\Models;

use App\Models\MyModel;

class RelationshipModel extends MyModel
{
    protected $table      = 'relationship';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id',
        'candidate_table',
        'candidate_key',
        'foreign_table',
        'foreign_key',
    ];

    function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = empty($sort) ? 'id' : $sort;
        $order = empty($order) ? 'DESC' : $order;

        if (!empty($filter["candidate_table"])) {
            $this->like('candidate_table', $filter["candidate_table"]);
        }

        if (!empty($filter["foreign_table"])) {
            $this->like('foreign_table', $filter["foreign_table"]);
        }

        return $this->orderBy($sort, $order);
    }

    public function addRelationship($candidate_table, $candidate_key, $foreign_table, $foreign_key)
    {
        if (empty($candidate_table) || empty($candidate_key) || empty($foreign_table) || empty($foreign_key)) {
            return false;
        }

        $relation = $this->getRelationship($candidate_table, $candidate_key, $foreign_table, $foreign_key);
        if (!empty($relation)) {
            return false;
        }

        $data = [
            'candidate_table' => $candidate_table,
            'candidate_key'   => $candidate_key,
            'foreign_table'   => $foreign_table,
            'foreign_key'     => $foreign_key,
        ];

        return $this->insert($data);
    }

    public function getRelationship($candidate_table, $candidate_key, $foreign_table, $foreign_key)
    {
        if (empty($candidate_table) || empty($candidate_key) || empty($foreign_table) || empty($foreign_key)) {
            return false;
        }


        $data = [
            'candidate_table' => $candidate_table,
            'candidate_key'   => $candidate_key,
            'foreign_table'   => $foreign_table,
            'foreign_key'     => $foreign_key,
        ];

        $return = $this->where($data)->findAll();
        if (empty($return)) {
            return false;
        }

        return $return;
    }

    public function getCandidate($candidate_table, $foreign_table, $candidate_key)
    {
        if (empty($candidate_table) || empty($foreign_table) || empty($candidate_key)) {
            return false;
        }

        $data = [
            'candidate_table' => $candidate_table,
            'candidate_key'   => $candidate_key,
            'foreign_table'   => $foreign_table,
        ];

        $return = $this->orderBy('id', 'DESC')->where($data)->findAll();
        if (empty($return)) {
            return false;
        }

        return $return;
    }
}
