<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLayoutModulesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'layout_id INT(11) UNSIGNED NOT NULL',
            'layout_action_id INT(11) UNSIGNED NOT NULL',
            'position VARCHAR(16) NOT NULL',
            'sort_order INT(3) NULL DEFAULT 0',
        ]);

        // Thêm index cho các cột
        $this->forge->addUniqueKey(['layout_id', 'layout_action_id', 'position']);

        $this->forge->addForeignKey('layout_id', 'layouts', 'layout_id', 'CASCADE', '', 'fk_layout_modules_layout_id');
        $this->forge->addForeignKey('layout_action_id', 'layout_actions', 'layout_action_id', 'CASCADE', '', 'fk_layout_modules_layout_action_id');

        // Tạo bảng
        $this->forge->createTable('layout_modules', true);
    }

    public function down()
    {
        $this->forge->dropTable('layout_modules');
    }
}
