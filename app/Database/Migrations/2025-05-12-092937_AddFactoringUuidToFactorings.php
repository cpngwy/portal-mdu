<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFactoringUuidToFactorings extends Migration
{
    public function up()
    {
        $this->forge->addColumn('factorings', [
            'factoring_uuid' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'status'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('factorings', 'factoring_uuid');
    }
}
