<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateConfigsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
            'config_key VARCHAR(255) NOT NULL',
            'config_value TEXT NOT NULL',
            'description VARCHAR(255) NOT NULL',
            'group_id INT(11) UNSIGNED NULL',
            'user_id BIGINT(20) UNSIGNED DEFAULT NULL',
            'published TINYINT(1) NOT NULL DEFAULT 1',
            'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->forge->addKey('id', true);
        //$this->forge->addKey('config_key'); // nếu muốn index

        $this->forge->addForeignKey(
            'group_id',
            'config_groups',
            'id',
            'CASCADE',
            'CASCADE',
            'fk_configs_group_id'
        );

        $this->forge->createTable('configs', true);
    }

    public function down()
    {
        $this->forge->dropTable('configs', true);
    }
}