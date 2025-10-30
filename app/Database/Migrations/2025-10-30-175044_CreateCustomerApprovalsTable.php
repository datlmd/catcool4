<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomerApprovalsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'customer_approval_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT',
            'customer_id BIGINT UNSIGNED NOT NULL',
            'type VARCHAR(9) NOT NULL',
            'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ]);

        // Khóa chính
        $this->forge->addKey('customer_approval_id', true);

        // Tạo bảng
        $this->forge->createTable('customer_approvals', true);
    }

    public function down()
    {
        $this->forge->dropTable('customer_approvals');
    }
}
