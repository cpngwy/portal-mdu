<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEmailToBuyerRepresentatives extends Migration
{
    public function up()
    {
        $this->forge->addColumn('buyer_representatives', [
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'after'      => 'birth_date',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('buyer_representatives', 'email');
    }
}
