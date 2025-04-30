<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BuyerAddress extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'buyer_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'country_code' => [
                'type'       => 'VARCHAR',
                'constraint' => '2',
            ],
            'state' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'city' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'zip_code' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'address_line1' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'address_line2' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['billing', 'shipping'],
                'comment'    => 'billing or shipping',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Active', 'Inactive'],
                'comment'    => 'Active or Inactive',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true); // Primary Key
        $this->forge->addForeignKey('buyer_id', 'buyers', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('buyer_addresses');
    }

    public function down()
    {
        $this->forge->dropTable('buyer_addresses');
    }
}
