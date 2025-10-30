<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomerWishlistsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'customer_id BIGINT UNSIGNED NOT NULL',
            'product_id BIGINT UNSIGNED NOT NULL',
            'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ]);

        // Khóa chính
        $this->forge->addKey(['customer_id', 'product_id'], true);

        // Tạo bảng
        $this->forge->createTable('customer_wishlists', true);
    }

    public function down()
    {
        $this->forge->dropTable('customer_wishlists');
    }
}
