<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Factoring extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'supplier_code' => ['type' => 'VARCHAR', 'constraint' => 50],
            'buyer_code' => ['type' => 'VARCHAR', 'constraint' => 50],
            'invoice_external_reference_id' => ['type' => 'VARCHAR', 'constraint' => 100],
            'currency' => ['type' => 'VARCHAR', 'constraint' => 3],
            'net_term' => ['type' => 'INT'],
            'payment_method' => ['type' => 'VARCHAR', 'constraint' => 50],
            'total_discount_cents' => ['type' => 'INT'],
            'invoice_issued_at' => ['type' => 'DATETIME'],
            'gross_amount_cents' => ['type' => 'INT'],
            'language' => ['type' => 'VARCHAR', 'constraint' => 10],
            'invoice_url' => ['type' => 'TEXT', 'null' => true],
            'file' => ['type' => 'TEXT', 'null' => true],
            'owner_first_name' => ['type' => 'VARCHAR', 'constraint' => 50],
            'owner_last_name' => ['type' => 'VARCHAR', 'constraint' => 50],
            'owner_is_authorized' => ['type' => 'BOOLEAN'],
            'status' => ['type' => 'ENUM', 'constraint' => ['pending', 'approved', 'rejected'], 'default' => 'pending'],
            "created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP",
            "updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP"
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('factorings');
    }

    public function down()
    {
        $this->forge->dropTable('factorings');
    }
}
