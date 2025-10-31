<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAttributesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'attribute_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT',
            'attribute_group_id BIGINT UNSIGNED NOT NULL',
            'sort_order INT(3) NOT NULL',
        ]);

        $this->forge->addKey('attribute_id', true);

        $this->forge->createTable('attributes', true);

        /**
         * Table attribute_translations
         */

        $this->forge->addField([
            'attribute_id BIGINT UNSIGNED NOT NULL',
            'language_id BIGINT UNSIGNED NOT NULL',
            'name VARCHAR(100) NOT NULL',
        ]);

        // Khóa chính kép
        $this->forge->addKey(['attribute_id', 'language_id'], true);

        $this->forge->addForeignKey(
            'attribute_id',
            'attributes',
            'attribute_id',
            'CASCADE',
            'CASCADE',
            'fk_attribute_translations_attribute_id'
        );

        $this->forge->createTable('attribute_translations', true);
    }

    public function down()
    {
        $this->forge->dropTable('attribute_translations');
        $this->forge->dropTable('attributes');
    }
}