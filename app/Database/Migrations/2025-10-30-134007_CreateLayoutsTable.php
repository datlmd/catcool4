<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLayoutsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'layout_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
            'name VARCHAR(100) NOT NULL',
        ]);

        $this->forge->addKey('layout_id', true); // Primary key
        $this->forge->createTable('layouts', true);
    }

    public function down()
    {
        $this->forge->dropTable('layouts');
    }
}
