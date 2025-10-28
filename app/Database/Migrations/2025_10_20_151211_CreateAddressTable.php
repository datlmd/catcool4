<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAddressTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'address_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true,
                'null' => false,
            ],
            'customer_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'null' => false,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'firstname' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => true,
            ],
            'lastname' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => true,
            ],
            'company' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'address_1' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'address_2' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => true,
            ],
            'postcode' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'country_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'null' => true,
            ],
            'province_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'null' => true,
            ],
            'district_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'null' => true,
            ],
            'ward_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'null' => true,
            ],
            'custom_field' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'default' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => true,
            ],
            'type' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => true,
            ],
        ]);

        $this->forge->addKey('address_id', true);
        $this->forge->addKey('customer_id');

        $this->forge->createTable('addresses');

        //Table address_format
        $this->forge->addField([
            'address_format_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => false,
            ],
            'address_format' => [
                'type' => 'TEXT',
                'null' => false,
            ],
        ]);
        $this->forge->addKey('address_format_id', true);
        $this->forge->createTable('address_formats');
    }

    public function down()
    {
        $this->forge->dropTable('address_formats');
        $this->forge->dropTable('addresses');
    }
}