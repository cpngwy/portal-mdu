<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SellerBuyer extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'seller_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'buyer_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'piva' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'registration_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'country_code' => [
                'type'       => 'VARCHAR',
                'constraint' => '2',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Active', 'Inactive'],
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

        $this->forge->addForeignKey('seller_id', 'sellers', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('buyer_id', 'buyers', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('seller_buyers');
    }

    public function down()
    {
        $this->forge->dropTable('seller_buyers');
    }
}
