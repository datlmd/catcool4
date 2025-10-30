<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMenusTable extends Migration
{
    public function up()
    {
        /**
         * Table Menus
         */
        $this->forge->addField([
            'menu_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
            'context VARCHAR(100) NULL',
            'icon VARCHAR(100) NULL',
            'image VARCHAR(255) NULL',
            'nav_key VARCHAR(100) NULL',
            'label VARCHAR(100) NULL',
            'attributes VARCHAR(255) NULL',
            'selected TEXT NULL',
            'sort_order INT(3) NULL DEFAULT 0',
            'user_id BIGINT UNSIGNED NULL',
            'parent_id INT(11) UNSIGNED NULL',
            'is_admin TINYINT(1) NOT NULL DEFAULT 0',
            'hidden TINYINT(1) NOT NULL DEFAULT 0',
            'published TINYINT(1) NOT NULL DEFAULT 1',
            'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->forge->addKey('menu_id', true); // Primary Key
        $this->forge->addKey('parent_id');     // Index
        $this->forge->createTable('menus', true);

        /**
         * Table menu_translations
         */
        $this->forge->addField([
            'menu_id INT(11) UNSIGNED NOT NULL',
            'language_id INT(11) UNSIGNED NOT NULL',
            'name VARCHAR(255) NOT NULL',
            'description TEXT NULL',
            'slug VARCHAR(255) NULL',
        ]);

        // 🔑 Composite primary key
        $this->forge->addKey(['menu_id', 'language_id'], true);

        // 🔗 Foreign keys
        $this->forge->addForeignKey(
            'menu_id',
            'menus',
            'menu_id',
            'CASCADE',
            'CASCADE',
            'fk_menu_translations_menu_id'
        );
        // $this->forge->addForeignKey(
        //     'language_id',
        //     'languages',
        //     'id',
        //     'CASCADE',
        //     'CASCADE',
        //     'fk_menu_translations_language_id'
        // );

        // 🧱 Create table
        $this->forge->createTable('menu_translations', true);
    }

    public function down()
    {
        $this->forge->dropTable('menu_translations');
        $this->forge->dropTable('menus');
    }
}