<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'page_id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT',
            'body_class VARCHAR(50) NULL',
            'layout VARCHAR(50) NULL',
            'sort_order INT(3) NULL DEFAULT 0',
            'published TINYINT(1) NOT NULL DEFAULT 1',
            'deleted_at DATETIME NULL DEFAULT NULL',
            'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        // Thiết lập khóa chính và index
        $this->forge->addKey('page_id', true); // Primary key
        $this->forge->addKey('published');     // Index
        $this->forge->addKey('deleted_at');    // Index

        // Tạo bảng
        $this->forge->createTable('pages');

        /**
         * Tạo table: page_translations
         */
        $this->forge->addField([
            'page_id BIGINT(20) UNSIGNED NOT NULL',
            'language_id INT(11) UNSIGNED NOT NULL',
            'name VARCHAR(255) NOT NULL',
            'slug VARCHAR(255) NULL',
            'content MEDIUMTEXT NOT NULL',
            'meta_title VARCHAR(255) NULL DEFAULT NULL',
            'meta_description TEXT NULL DEFAULT NULL',
            'meta_keyword TEXT NULL DEFAULT NULL',
        ]);

        // Khóa chính kép
        $this->forge->addKey(['page_id', 'language_id'], true);

        $this->forge->addForeignKey(
            'page_id',
            'pages',
            'page_id',
            'CASCADE',
            'CASCADE',
            'fk_page_translations_page_id'
        );

        // Tạo bảng
        $this->forge->createTable('page_translations');
    }

    public function down()
    {
        $this->forge->dropTable('page_translations');
        $this->forge->dropTable('pages');
    }
}
