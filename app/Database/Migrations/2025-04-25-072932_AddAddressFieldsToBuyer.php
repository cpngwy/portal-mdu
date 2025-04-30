<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAddressFieldsToBuyer extends Migration
{
    public function up()
    {
        $this->forge->addColumn('buyers', [
            'country_code' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true, 'after' => 'api_key'],
            'city'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true, 'after' => 'country_code'],
            'state'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true, 'after' => 'city'],
            'zip_code'     => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true, 'after' => 'state'],
            'address_line1'=> ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'zip_code'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('buyers', ['country_code', 'city', 'state', 'zip_code', 'address_line1']);
    }
}
