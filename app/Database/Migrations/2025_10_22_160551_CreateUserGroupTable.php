<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserGroupTable extends Migration
{
    public function up()
    {
        $attributes = ['ENGINE' => 'InnoDB'];

        /*
         * Table user_group
         */
        $this->forge->addField([
            'id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT',
            'name VARCHAR(50) NOT NULL',
            'description VARCHAR(100) NULL',
        ]);

        // Primary key
        $this->forge->addKey('id', true);

        $this->forge->createTable('user_groups', true, $attributes);

        /*
         * Table user_groups
         */
        $this->forge->addField([
            'user_id BIGINT(20) UNSIGNED NOT NULL',
            'group_id BIGINT(20) UNSIGNED NOT NULL',
        ]);

        // Composite Primary Key
        $this->forge->addKey(['user_id', 'group_id'], true); // true = PRIMARY KEY

        $this->forge->addKey('user_id');
        $this->forge->addKey('group_id');

        $this->forge->addForeignKey('group_id', 'user_groups', 'id', 'CASCADE', 'CASCADE', 'fk_user_to_groups_group_id');
        $this->forge->addForeignKey('user_id', 'users', 'user_id', 'CASCADE', 'CASCADE', 'fk_user_to_groups_user_id');

        // Create table
        $this->forge->createTable('user_to_groups', true, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('user_to_groups');
        $this->forge->dropTable('user_groups');
    }
}