<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRoutesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'route VARCHAR(255) NOT NULL',
            'language_id INT(11) NOT NULL',
            'module VARCHAR(255) NOT NULL',
            'resource VARCHAR(255) NOT NULL',
            'user_id BIGINT(20) UNSIGNED DEFAULT NULL',
            'published TINYINT(1) NOT NULL DEFAULT 1',
            'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        // ✅ Composite Primary Key
        $this->forge->addKey(['route', 'language_id'], true);

        // Optional Indexes (nếu cần)
        // $this->forge->addKey('language_id');
        // $this->forge->addKey('user_id');

        $this->forge->createTable('routes');
    }

    public function down()
    {
        $this->forge->dropTable('routes');
    }
}