<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomerHistoriesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'customer_history_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT',
            'customer_id BIGINT UNSIGNED NOT NULL',
            'comment TEXT NOT NULL',
            'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ]);

        // Khóa chính
        $this->forge->addKey('customer_history_id', true);

        // Tạo bảng
        $this->forge->createTable('customer_histories', true);
    }

    public function down()
    {
        $this->forge->dropTable('customer_histories');
    }
}
