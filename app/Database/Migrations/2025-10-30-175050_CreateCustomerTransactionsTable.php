<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomerTransactionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'customer_transaction_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT',
            'customer_id BIGINT UNSIGNED NOT NULL',
            'order_id INT(11) NOT NULL',
            'description TEXT NOT NULL',
            'amount DECIMAL(15,4) NOT NULL',
            'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ]);

        // Khóa chính
        $this->forge->addKey('customer_transaction_id', true);

        // Tạo bảng
        $this->forge->createTable('customer_transactions', true);
    }

    public function down()
    {
        $this->forge->dropTable('customer_transactions');
    }
}
