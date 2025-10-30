<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTranslationsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT',
            'lang_key VARCHAR(100) NOT NULL',
            'lang_value TEXT NOT NULL',
            'lang_id INT(11) UNSIGNED DEFAULT NULL',
            'module_id INT(11) UNSIGNED DEFAULT NULL',
            'user_id BIGINT(20) UNSIGNED DEFAULT NULL',
            'published TINYINT(1) NOT NULL DEFAULT 1',
            'deleted_at DATETIME DEFAULT NULL',
            'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        // ✅ Primary Key
        $this->forge->addKey('id', true);

        // ✅ Indexes
        $this->forge->addKey('lang_key');
        $this->forge->addKey('lang_id');
        $this->forge->addKey('module_id');

        $this->forge->createTable('translations', true);
    }

    public function down()
    {
        $this->forge->dropTable('translations');
    }
}