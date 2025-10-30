<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLayoutActionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'layout_action_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
            'name VARCHAR(255) NOT NULL',
            'controller VARCHAR(255) NOT NULL',
            'action VARCHAR(255) NOT NULL',
        ]);

        $this->forge->addKey('layout_action_id', true);
        $this->forge->createTable('layout_actions');
    }

    public function down()
    {
        $this->forge->dropTable('layout_actions');
    }
}
