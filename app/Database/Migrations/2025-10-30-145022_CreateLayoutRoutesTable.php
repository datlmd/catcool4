<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLayoutRoutesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'layout_id INT(11) UNSIGNED NOT NULL',
            'store_id BIGINT UNSIGNED NOT NULL DEFAULT 0',
            'route VARCHAR(100) NOT NULL',
        ]);

        $this->forge->addUniqueKey(['layout_id', 'store_id', 'route']);

        $this->forge->addForeignKey('layout_id', 'layouts', 'layout_id', 'CASCADE', '', 'fk_layout_routes_layout_id');

        $this->forge->createTable('layout_routes');
    }

    public function down()
    {
        $this->forge->dropTable('layout_routes');
    }
}
