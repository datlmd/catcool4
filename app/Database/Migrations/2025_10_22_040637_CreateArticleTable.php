<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateArticleTable extends Migration
{
    public function up()
    {
        $attributes = ['ENGINE' => 'InnoDB'];

        //Table article
        $this->forge->addField([
            'article_id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'publish_date' => [
                'type'    => 'datetime',
                'null'    => false
            ],
            'is_comment' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'null'       => true,
            ],
            'is_toc' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'null'       => true,
            ],
            'images' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'tags' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'author' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'source' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 3,
                'default'    => 0,
                'null'       => true,
            ],
            'category_ids' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'user_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
                'null'       => true,
            ],
            'ip' => [
                'type'       => 'VARCHAR',
                'constraint' => 40,
                'default'    => '0.0.0.0',
                'null'       => true,
            ],
            'counter_view' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
                'null'       => true,
            ],
            'counter_comment' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
                'null'       => true,
            ],
            'counter_like' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
                'null'       => true,
            ],
            'published' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'deleted_at' => [
                'type' => 'timestamp',
                'null' => true,
            ],
            'created_at' => [
                'type'    => 'timestamp',
                'null'    => false,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'timestamp',
                'null' => true,
                'default' => new RawSql('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addPrimaryKey('article_id');

        $this->forge->addKey('publish_date');
        $this->forge->addKey('published');
        $this->forge->addKey('deleted_at');

        $this->forge->createTable('articles', true, $attributes);

        //Table article_lang
        $this->forge->addField('article_id BIGINT(20) UNSIGNED NOT NULL');
        $this->forge->addField('language_id BIGINT UNSIGNED NOT NULL');
        $this->forge->addField('name VARCHAR(255) NOT NULL');
        $this->forge->addField('slug VARCHAR(255) NULL');
        $this->forge->addField('description VARCHAR(255) NULL');
        $this->forge->addField('content MEDIUMTEXT NULL');
        $this->forge->addField('meta_title VARCHAR(255) NULL');
        $this->forge->addField('meta_description TEXT NULL');
        $this->forge->addField('meta_keyword TEXT NULL');

        $this->forge->addPrimaryKey(['article_id', 'language_id']);

        $this->forge->addForeignKey('article_id', 'articles', 'article_id', 'CASCADE', 'CASCADE', 'fk_article_translations_article_id');

        $this->forge->createTable('article_translations', true, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('article_translations');
        $this->forge->dropTable('articles');
    }
}