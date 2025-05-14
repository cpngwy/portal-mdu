<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterFactoringsAddStatusConfirmed extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('factorings', [
            'status' => [
                'type'    => 'ENUM',
                'constraint' => ['processing', 'pending', 'approved', 'declined', 'confirmed'],
                'null'    => false,
                'default' => 'pending'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('factorings', [
            'status' => [
                'type'    => 'ENUM',
                'constraint' => ['processing', 'pending', 'approved', 'declined'],
                'null'    => false,
                'default' => 'pending'
            ],
        ]);
    }
}
