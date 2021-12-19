<?php namespace App\Modules\Manage\Models;


class BackupModel
{
    protected $db;

    function __construct()
    {
        $this->db = db_connect();
    }

    public function getTables(): array
    {
        return $this->db->listTables();
    }

    public function getRecords(string $table, int $start = 0, int $limit = 100): array
    {
        if ($start < 0) {
            $start = 0;
        }

        if ($limit < 1) {
            $limit = 10;
        }

        $query = $this->db->query("SELECT * FROM `" . $table . "` LIMIT " . (int)$start . "," . (int)$limit);

        if (empty($query->getResultArray())) {
            return [];
        }

        return $query->getResultArray();
    }

    public function getTotalRecords(string $table): int
    {
        $query = $this->db->query("SELECT COUNT(*) AS `total` FROM `" . $table . "`");

        $result = $query->getRowArray();
        if (empty($result)) {
            return 0;
        }

        return (int)$result['total'];
    }
}
