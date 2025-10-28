<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateModulesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
            'module VARCHAR(100) NOT NULL',
            'sub_module VARCHAR(100) NULL',
            'user_id BIGINT UNSIGNED NULL',
            'published TINYINT(1) NOT NULL DEFAULT 1',
            'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->forge->addKey('id', true); // Primary key
        //$this->forge->addKey('user_id');

        // Nếu có bảng users thì mở dòng này
        // $this->forge->addForeignKey('user_id', 'users', 'id', 'SET NULL', 'CASCADE');

        $this->forge->createTable('modules');
    }

    public function down()
    {
        $this->forge->dropTable('modules');
    }
}