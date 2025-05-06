<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterFactoringAddFieldsCreatedByUpdatedBy extends Migration
{
    public function up()
    {
        $this->forge->addColumn('factorings', [
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'after'      => 'updated_at',
            ],
            'updated_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'after'      => 'created_by',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('factorings', ['created_by', 'updated_by']);
    }
}
