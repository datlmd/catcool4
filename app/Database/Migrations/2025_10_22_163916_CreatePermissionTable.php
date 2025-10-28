<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePermissionTable extends Migration
{
    public function up()
    {
        $attributes = ['ENGINE' => 'InnoDB'];

        /*
         * Table permission
         */
        $this->forge->addField([
            'id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT',
            'name VARCHAR(50) NOT NULL',
            'description VARCHAR(100) NOT NULL',
            'published TINYINT(1) NOT NULL DEFAULT 1',
        ]);

        // Primary key
        $this->forge->addKey('id', true);

        // Index cho cột 'name'
        $this->forge->addKey('name');

        $this->forge->createTable('permissions', false, $attributes);

        /*
         * Table user_permissions
         */
        $this->forge->addField([
            'user_id BIGINT(20) UNSIGNED NOT NULL',
            'permission_id BIGINT(20) UNSIGNED NOT NULL',
        ]);

        // Composite Primary Key
        $this->forge->addKey(['user_id', 'permission_id'], true);

        $this->forge->addKey('user_id');
        $this->forge->addKey('permission_id');

        $this->forge->addForeignKey('user_id', 'users', 'user_id', 'CASCADE', 'CASCADE', 'fk_user_to_permissions_user_id');
        $this->forge->addForeignKey('permission_id', 'permissions', 'id', 'CASCADE', 'CASCADE', 'fk_user_to_permissions_permission_id');

        // Create table
        $this->forge->createTable('user_to_permissions', false, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('user_to_permissions');
        $this->forge->dropTable('permissions');
    }
}