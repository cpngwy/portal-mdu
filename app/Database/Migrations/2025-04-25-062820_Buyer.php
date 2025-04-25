<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Buyer extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'buyer_code'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'name'            => ['type' => 'VARCHAR', 'constraint' => 255],
            'piva'            => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'registration_id' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'api_key'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status'          => ['type' => 'ENUM', 'constraint' => ['active', 'inactive'], 'default' => 'active'],
            "created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP",
            "updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP",
            "deleted_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP"
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('buyers');
    }
    public function down()
    {
        $this->forge->dropTable('buyers');
    }
}
