<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterUserAddForeignKeys extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('users', [
            'seller_code' => [
                'name'       => 'seller_id',
                'type'       => 'INT',
                'unsigned'       => true,
            ],
            'buyer_code' => [
                'name'       => 'buyer_id',
                'type'       => 'INT',
                'unsigned'       => true,
            ],
        ]);

        $this->forge->addForeignKey('seller_id', 'sellers', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('buyer_id', 'buyers', 'id', 'SET NULL', 'CASCADE');
        $this->forge->processIndexes('users');
    }
    
    public function down()
    {
        $this->forge->dropForeignKey('users', 'users_seller_id_foreign');
        $this->forge->dropForeignKey('users', 'users_buyer_id_foreign');

        // Rename columns back
        $this->forge->modifyColumn('users', [
            'seller_id' => [
                'name'       => 'seller_code',
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'buyer_id' => [
                'name'       => 'buyer_code',
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
        ]);
    }
}
