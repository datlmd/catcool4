<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'customer_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT',
            'username VARCHAR(100) NULL',
            'password VARCHAR(255) NOT NULL',
            'email VARCHAR(96) NULL',
            'name VARCHAR(255) NULL',
            'first_name VARCHAR(50) NULL',
            'last_name VARCHAR(50) NULL',
            'company VARCHAR(100) NULL',
            'phone VARCHAR(32) NULL',
            'fax VARCHAR(32) NULL',
            'address_id BIGINT(20) UNSIGNED NULL DEFAULT 0',
            'dob DATE NULL DEFAULT NULL',
            'gender TINYINT(1) NULL DEFAULT 1',
            'image VARCHAR(255) NULL',
            'salt VARCHAR(9) NULL',
            'cart TEXT NOT NULL',
            'wishlist TEXT NOT NULL',
            'newsletter TINYINT(1) NULL DEFAULT 0',
            'custom_field TEXT NOT NULL',
            'safe TINYINT(1) NULL DEFAULT NULL',
            'activation_selector VARCHAR(255) NULL',
            'activation_code VARCHAR(255) NULL',
            'forgotten_password_selector VARCHAR(255) NULL',
            'forgotten_password_code VARCHAR(255) NULL',
            'forgotten_password_time INT(11) UNSIGNED NULL DEFAULT NULL',
            'active TINYINT(1) NULL DEFAULT NULL',
            'language_id BIGINT UNSIGNED NOT NULL',
            'customer_group_id BIGINT UNSIGNED NOT NULL DEFAULT 0',
            'store_id BIGINT NOT NULL DEFAULT 0',
            "ip VARCHAR(40) NULL DEFAULT '0.0.0.0'",
            'last_login INT(11) UNSIGNED NULL DEFAULT NULL',
            'deleted_at DATETIME NULL DEFAULT NULL',
            'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        // 🔑 Khóa chính
        $this->forge->addKey('customer_id', true);

        $this->forge->addKey('username');
        $this->forge->addKey('email');
        $this->forge->addKey('phone');
        $this->forge->addKey('activation_selector');
        $this->forge->addKey('forgotten_password_selector');

        // 🧱 Tạo bảng
        $this->forge->createTable('customers', true);


        /**
         * Table customer_ips
         */
        $this->forge->addField([
            'customer_ip_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT',
            'customer_id BIGINT UNSIGNED NOT NULL',
            'ip VARCHAR(40) NOT NULL',
            'store_id BIGINT UNSIGNED DEFAULT 0',
            'country VARCHAR(2) DEFAULT NULL',
            'agent VARCHAR(255) DEFAULT NULL',
            'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ]);

        // Khóa chính
        $this->forge->addKey('customer_ip_id', true);

        // Chỉ mục cho cột ip
        $this->forge->addKey('ip');

        // Tạo bảng
        $this->forge->createTable('customer_ips', true);

        /**
         * Table customer_login_attempts
         */
        $this->forge->addField([
            'id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT',
            'ip VARCHAR(40) NULL DEFAULT "0.0.0.0"',
            'customer_id BIGINT UNSIGNED NOT NULL',
            'time INT(11) UNSIGNED DEFAULT NULL',
        ]);

        // Khóa chính
        $this->forge->addKey('id', true);

        // Chỉ mục cho cột ip và customer_id
        $this->forge->addKey(['ip', 'customer_id']);

        // Tạo bảng
        $this->forge->createTable('customer_login_attempts', true);

        /**
         * Table customer_login_socials
         */
        $this->forge->addField([
            'social_id VARCHAR(255) NOT NULL',
            'customer_id BIGINT UNSIGNED DEFAULT NULL',
            'type VARCHAR(5) DEFAULT NULL',
            'access_token VARCHAR(255) DEFAULT NULL',
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        // Khóa chính
        $this->forge->addKey('social_id', true);

        // Chỉ mục cho customer_id và type
        $this->forge->addKey('customer_id');
        $this->forge->addKey('type');

        // Tạo bảng
        $this->forge->createTable('customer_login_socials', true);

        /**
         * Table customer_tokens
         */
        $this->forge->addField([
            'customer_id BIGINT UNSIGNED NOT NULL',
            'remember_selector VARCHAR(255) NOT NULL',
            'remember_code VARCHAR(255) DEFAULT NULL',
            'ip VARCHAR(40) NULL DEFAULT "0.0.0.0"',
            'agent VARCHAR(255) NULL DEFAULT NULL',
            'platform VARCHAR(255) NULL DEFAULT NULL',
            'browser VARCHAR(255) NULL DEFAULT NULL',
            'location VARCHAR(255) NULL DEFAULT NULL',
            'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        // Khóa chính kép
        $this->forge->addKey(['customer_id', 'remember_selector'], true);

        // Tạo bảng
        $this->forge->createTable('customer_tokens', true);
    }

    public function down()
    {
        $this->forge->dropTable('customer_tokens');
        $this->forge->dropTable('customer_login_socials');
        $this->forge->dropTable('customer_login_attempts');
        $this->forge->dropTable('customer_ips');
        $this->forge->dropTable('customers');
    }
}