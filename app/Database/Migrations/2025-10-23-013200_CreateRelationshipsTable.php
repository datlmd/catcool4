<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRelationshipsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT',
            'candidate_table VARCHAR(100) NOT NULL',
            'candidate_key BIGINT(20) UNSIGNED NOT NULL',
            'foreign_table VARCHAR(100) NOT NULL',
            'foreign_key BIGINT(20) UNSIGNED NOT NULL',
        ]);

        // Primary Key
        $this->forge->addKey('id', true);

        // Indexes
        $this->forge->addKey('candidate_table');
        $this->forge->addKey('candidate_key');
        $this->forge->addKey('foreign_table');
        $this->forge->addKey('foreign_key');

        $this->forge->addUniqueKey([
            'candidate_table',
            'candidate_key',
            'foreign_table',
            'foreign_key'
        ], 'unique_key');

        $this->forge->createTable('relationships', true);
    }

    public function down()
    {
        $this->forge->dropTable('relationships');
    }
}