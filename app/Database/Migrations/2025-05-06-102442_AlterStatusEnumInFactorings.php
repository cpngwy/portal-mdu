<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterStatusEnumInFactorings extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('factorings', [
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['processing', 'pending', 'approved', 'declined'],
                'null'       => true,
                'default'    => 'pending',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('factorings', [
            'status' => [
                'type'       => 'ENUM',
                'constraint' => [ 'approved', 'pending', 'rejected'],
                'null'       => true,
                'default'    => 'pending',
            ],
        ]);
    }
}
