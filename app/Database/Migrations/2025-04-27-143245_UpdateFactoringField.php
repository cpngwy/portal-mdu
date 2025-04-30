<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateFactoringField extends Migration
{
    public function up()
    {
        $fields = [
            'total_discount_cents' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
            'gross_amount_cents' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
        ];

        $this->forge->modifyColumn('factorings', $fields);
    }

    public function down()
    {
        $fields = [
            'total_discount_cents' => ['type' => 'INT'],
            'gross_amount_cents' => ['type' => 'INT'],
        ];

        $this->forge->modifyColumn('factorings', $fields);
    }
}
