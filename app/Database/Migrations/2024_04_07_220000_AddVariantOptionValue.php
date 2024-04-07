<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Class AddVariantOptionValue
 * php spark migrate:file "app/Database/Migrations/2024_04_07_220000_AddVariantOptionValue.php"
 * @package App\Database\Migrations
 */
class AddVariantOptionValue extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'variant_option_value_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'variant_option_id' => [
                'type'       => 'INT',
                'constraint' => '11',
                'unsigned'   => true,
            ],
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 3,
            ],
        ]);
        $this->forge->addKey('variant_option_value_id', true);
        $this->forge->createTable('variant_option_value');

        $this->forge->addField([
            'variant_option_value_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'language_id' => [
                'type'       => 'INT',
                'constraint' => '11',
            ],
            'variant_option_id' => [
                'type'       => 'INT',
                'constraint' => '11',
                'unsigned'   => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 128,
                //'collation'  => 'utf8_general_ci',
            ],
        ]);
        $this->forge->addKey(['variant_option_value_id', 'language_id'], true);

        $this->db->disableForeignKeyChecks();

        $this->forge->addForeignKey('variant_option_value_id', 'variant_option_value', 'variant_option_value_id', 'NO ACTION', 'CASCADE', 'variant_option_value_lang_ibfk_1');

        $this->db->enableForeignKeyChecks();

        $this->forge->createTable('variant_option_value_lang');
    }

    public function down()
    {
        $this->forge->dropTable('variant_option_value_lang');
        $this->forge->dropTable('variant_option_value');
    }
}
