<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropApiKeyFromBuyers extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('buyers', 'api_key');
    }

    public function down()
    {
        $this->forge->addColumn('buyers', [
            'api_key' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true]
        ]);
    }
}
