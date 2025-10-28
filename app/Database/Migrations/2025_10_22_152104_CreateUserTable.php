<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserTable extends Migration
{
    public function up()
    {
        $attributes = ['ENGINE' => 'InnoDB'];

        /*
         * Table user
         */
        $this->forge->addField([
            'user_id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT',
            'username VARCHAR(100) NOT NULL',
            'password VARCHAR(255) NOT NULL',
            'email VARCHAR(255) NULL',
            'name VARCHAR(255) NULL',
            'first_name VARCHAR(100) NULL',
            'last_name VARCHAR(100) NULL',
            'company VARCHAR(100) NULL',
            'phone VARCHAR(20) NULL',
            'address VARCHAR(255) NULL',
            'dob DATE NULL',
            'gender TINYINT(1) NULL DEFAULT 1',
            'image VARCHAR(255) NULL',
            'super_admin TINYINT(1) UNSIGNED NULL',
            'activation_selector VARCHAR(255) NULL',
            'activation_code VARCHAR(255) NULL',
            'forgotten_password_selector VARCHAR(255) NULL',
            'forgotten_password_code VARCHAR(255) NULL',
            'forgotten_password_time INT(10) UNSIGNED NULL',
            'last_login INT(10) UNSIGNED NULL',
            'active TINYINT(1) UNSIGNED NULL',
            'language_id INT(11) UNSIGNED NULL',
            "ip VARCHAR(40) NULL DEFAULT '0.0.0.0'",
            'deleted_at DATETIME NULL',
            'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->forge->addKey('user_id', true);

        $this->forge->addKey('username');
        $this->forge->addKey('email');
        $this->forge->addKey('activation_selector');
        $this->forge->addKey('forgotten_password_selector');

        $this->forge->createTable('users', false, $attributes);

        /*
         * Table user_ip
         */
        $this->forge->addField([
            'user_ip_id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT',
            'user_id BIGINT(20) UNSIGNED NOT NULL',
            'ip VARCHAR(40) NOT NULL',
            'agent VARCHAR(255) NULL',
            'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ]);

        // PRIMARY KEY
        $this->forge->addKey('user_ip_id', true);

        // INDEXES
        $this->forge->addKey('ip');
        $this->forge->addKey('user_id');

        // Create table
        $this->forge->createTable('user_ips', false, $attributes);

        /*
         * Table user_login_attempt
         */
        $this->forge->addField([
            'id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT',
            "ip VARCHAR(40) NOT NULL DEFAULT '0.0.0.0'",
            'user_id BIGINT(20) NOT NULL',
            'time INT(11) UNSIGNED NULL',
        ]);

        // PRIMARY KEY
        $this->forge->addKey('id', true);

        // INDEXES
        $this->forge->addKey('user_id');

        // Create table
        $this->forge->createTable('user_login_attempts');

        /*
         * ***** Table user_token *****
         */
        $this->forge->addField([
            'user_id BIGINT(20) UNSIGNED NOT NULL',
            'remember_selector VARCHAR(255) NOT NULL',
            'remember_code VARCHAR(255) NULL',
            "ip VARCHAR(40) NULL DEFAULT '0.0.0.0'",
            'agent VARCHAR(255) NULL',
            'platform VARCHAR(255) NULL',
            'browser VARCHAR(255) NULL',
            'location VARCHAR(255) NULL',
            'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        // COMPOSITE PRIMARY KEY (user_id + remember_selector)
        $this->forge->addKey(['user_id', 'remember_selector'], true); // true = PRIMARY

        $this->forge->createTable('user_tokens');
    }

    public function down()
    {
        $this->forge->dropTable('user_tokens');
        $this->forge->dropTable('user_login_attempts');
        $this->forge->dropTable('user_ips');
        $this->forge->dropTable('users');
    }
}