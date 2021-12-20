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
        $prefix = $this->db->getPrefix();
        $result = $this->db->listTables();

        $ignore = [
            $prefix . 'user_admin',
            $prefix . 'user_admin_group',
            $prefix . 'user_admin_groups',
            $prefix . 'user_admin_permissions',
            $prefix . 'user_admin_token',
            $prefix . 'user_admin_login_attempt',
        ];

        foreach ($result as $key => $value) {
            if (in_array($value, $ignore)) {
                unset($result[$key]);
                continue;
            }
            $result[$key] = str_ireplace($prefix, '', $value);
        }

        ksort($result);

        return $result;
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
