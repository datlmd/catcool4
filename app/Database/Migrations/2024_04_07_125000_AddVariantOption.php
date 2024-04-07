<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Class AddVariantOption
 * php spark migrate:file "app/Database/Migrations/2024_04_07_125000_AddVariantOption.php"
 *
 * @package App\Database\Migrations
 */
class AddVariantOption extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'variant_option_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'type' => [
                'type'       => 'VARCHAR',
                'constraint' => '32',
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 3,
            ],
        ]);
        $this->forge->addKey('variant_option_id', true);
        $this->forge->createTable('variant_option');

        $this->forge->addField([
            'variant_option_id' => [
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
                'collation'  => 'utf8_general_ci',
            ],
        ]);
        $this->forge->addKey(['variant_option_id', 'language_id'], true);

        $this->db->disableForeignKeyChecks();

        $this->forge->addForeignKey('variant_option_id', 'variant_option', 'variant_option_id', 'NO ACTION', 'CASCADE', 'variant_option_lang_ibfk_1');

        $this->db->enableForeignKeyChecks();

        $this->forge->createTable('variant_option_lang');
    }

    public function down()
    {
        //$this->forge->dropForeignKey('variant_option_lang', 'variant_option_lang_ibfk_1');
        $this->forge->dropTable('variant_option_lang');
        $this->forge->dropTable('variant_option');
    }
}
