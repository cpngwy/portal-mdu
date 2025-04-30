<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BuyerRepresentative extends Migration
{public function up()
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
            'first_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'last_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'birth_date' => [
                'type' => 'DATE',
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['owner', 'authorized_person'],
                'comment'    => 'e.g., owner, authorized_person',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Active', 'Inactive'],
                'comment'    => 'Active, Inactive',
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
        $this->forge->addForeignKey('buyer_id', 'buyers', 'id', 'CASCADE', 'CASCADE'); // Foreign Key
        $this->forge->createTable('buyer_representatives');
    }

    public function down()
    {
        $this->forge->dropTable('buyer_representatives');
    }
}
