<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Class AddVariant
 * php spark migrate:file "app/Database/Migrations/2024_04_07_125000_AddVariant.php"
 *
 * @package App\Database\Migrations
 */
class AddVariant extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'variant_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 3,
            ],
        ]);
        $this->forge->addKey('variant_id', true);
        $this->forge->createTable('variant');

        $this->forge->addField([
            'variant_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true
            ],
            'language_id' => [
                'type'       => 'INT',
                'constraint' => '11',
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 128,
                //'collation'  => 'utf8_general_ci',
            ],
        ]);
        $this->forge->addKey(['variant_id', 'language_id'], true);

        $this->db->disableForeignKeyChecks();

        $this->forge->addForeignKey('variant_id', 'variant', 'variant_id', 'NO ACTION', 'CASCADE', 'variant_lang_ibfk_1');

        $this->db->enableForeignKeyChecks();

        $this->forge->createTable('variant_lang');
    }

    public function down()
    {
        //$this->forge->dropForeignKey('variant_lang', 'variant_lang_ibfk_1');
        $this->forge->dropTable('variant_lang');
        $this->forge->dropTable('variant');
    }
}
