<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateArticleCategoryTable extends Migration
{
    public function up()
    {
        $attributes = ['ENGINE' => 'InnoDB'];

        /*
         * Table article_category
         */
        $this->forge->addField('category_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY');
        $this->forge->addField('parent_id INT(11) UNSIGNED NULL');
        $this->forge->addField('image VARCHAR(255) NULL');
        $this->forge->addField('sort_order INT(3) NULL DEFAULT 0');
        $this->forge->addField('published TINYINT(1) NULL DEFAULT 1');
        $this->forge->addField('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');

        // Thêm index cho parent_id
        $this->forge->addKey('parent_id');

        $this->forge->createTable('article_categories', true, $attributes);

        /*
         * Table article_category_lang
         */
        $this->forge->addField([
            'category_id INT(11) UNSIGNED NOT NULL',
            'language_id BIGINT UNSIGNED NOT NULL',
            'name VARCHAR(255) NOT NULL',
            'slug VARCHAR(255) NULL',
            'description VARCHAR(255) NULL',
            'meta_title VARCHAR(255) NULL',
            'meta_description TEXT NULL',
            'meta_keyword TEXT NULL',
        ]);

        // Khóa chính kép
        $this->forge->addKey(['category_id', 'language_id'], true);

        // (Tùy chọn) Foreign key
        $this->forge->addForeignKey('category_id', 'article_categories', 'category_id', 'CASCADE', 'CASCADE', 'fk_article_category_translations_category_id');
        // $this->forge->addForeignKey('language_id', 'languages', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('article_category_translations', true, $attributes);

        /*
         * Table article_categories
         */
        $this->forge->addField([
            'article_id BIGINT(20) UNSIGNED NOT NULL',
            'category_id INT(11) UNSIGNED NOT NULL',
        ]);

        // Khóa chính kép
        $this->forge->addKey(['article_id', 'category_id'], true);

        $this->forge->addKey('article_id');
        $this->forge->addKey('category_id');

        $this->forge->addForeignKey('article_id', 'articles', 'article_id', 'CASCADE', 'CASCADE', 'fk_article_to_categories_article_id');
        $this->forge->addForeignKey('category_id', 'article_categories', 'category_id', 'CASCADE', 'CASCADE', 'fk_article_to_categories_category_id');

        $this->forge->createTable('article_to_categories', true, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('article_to_categories');
        $this->forge->dropTable('article_category_translations');
        $this->forge->dropTable('article_categories');
    }
}