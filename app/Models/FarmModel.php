<?php namespace App\Models;

class FarmModel extends MyModel
{
    public $_table_suffix_format = "_%s";

    public function __construct()
    {
        parent::__construct();
    }

    public function setTableNameYear($date = null)
    {
        if (empty($date)) {
            $date = time();
        }
        $postfix = date('Y', $date);

        // create table name
        $table_suffix   = sprintf($this->_table_suffix_format, $postfix);

        $db_table    = explode("_", $this->table);
        $this->table = $db_table[0] . $table_suffix;

        return $this;
    }
}
