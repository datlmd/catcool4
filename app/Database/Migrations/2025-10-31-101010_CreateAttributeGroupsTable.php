<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAttributeGroupsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'attribute_group_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT',
            'sort_order INT(3) NOT NULL DEFAULT 0',
        ]);

        $this->forge->addKey('attribute_group_id', true);

        $this->forge->createTable('attribute_groups', true);

        /**
         * Table attribute_group_translations
         */
        $this->forge->addField([
            'attribute_group_id BIGINT UNSIGNED NOT NULL',
            'language_id BIGINT UNSIGNED NOT NULL',
            'name VARCHAR(64) NOT NULL',
        ]);

        // Composite primary key
        $this->forge->addKey(['attribute_group_id', 'language_id'], true);

        // Foreign keys (tùy chọn, nếu bạn có bảng attribute_groups và languages)
        $this->forge->addForeignKey(
            'attribute_group_id',
            'attribute_groups',
            'attribute_group_id',
            'CASCADE',
            'CASCADE',
            'fk_attribute_group_translations_attribute_group_id'
        );

        $this->forge->createTable('attribute_group_translations', true);
    }

    public function down()
    {
        $this->forge->dropTable('attribute_group_translations');
        $this->forge->dropTable('attribute_groups');
    }
}