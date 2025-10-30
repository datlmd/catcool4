<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomerGroupsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'customer_group_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT',
            'approval INT(1) NOT NULL',
            'sort_order INT(3) NULL',
        ]);

        // Khóa chính kép
        $this->forge->addKey('customer_group_id', true);

        // Tạo bảng
        $this->forge->createTable('customer_groups', true);

        /**
         * Tạo table: customer_group_translations
         */
        $this->forge->addField([
            'customer_group_id BIGINT UNSIGNED NOT NULL',
            'language_id INT(11) NOT NULL',
            'name VARCHAR(32) NOT NULL',
            'description TEXT NULL',
        ]);

        // Khóa chính kép
        $this->forge->addKey(['customer_group_id', 'language_id'], true);

        $this->forge->addForeignKey(
            'customer_group_id',
            'customer_groups',
            'customer_group_id',
            'CASCADE',
            'CASCADE',
            'fk_customer_group_translations_customer_group_id'
        );

        // Tạo bảng
        $this->forge->createTable('customer_group_translations', true);
    }

    public function down()
    {
        $this->forge->dropTable('customer_group_translations');
        $this->forge->dropTable('customer_groups');
    }
}
