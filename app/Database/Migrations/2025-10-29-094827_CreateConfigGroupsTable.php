<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateConfigGroupsTable extends Migration
{
    public function up()
    {
         $this->forge->addField([
            'id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
            'name VARCHAR(50) NOT NULL',
            'description VARCHAR(100) NOT NULL',
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('config_groups', true);
    }

    public function down()
    {
        $this->forge->dropTable('config_groups', true);
    }
}