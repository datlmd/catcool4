<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLanguagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
            'name VARCHAR(100) NOT NULL',
            'code VARCHAR(100) NOT NULL',
            'icon VARCHAR(100) NULL',
            'user_id BIGINT UNSIGNED NULL',
            'published TINYINT(1) NOT NULL DEFAULT 1',
            'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->forge->addKey('id', true); // primary key
        $this->forge->createTable('languages');
    }

    public function down()
    {
        $this->forge->dropTable('languages');
    }
}