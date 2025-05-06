<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterFactoringFieldSupplierCodeAndBuyerCode extends Migration
{
    public function up()
    {
        // Rename the columns and make them nullable INT
        $this->forge->modifyColumn('factorings', [
            'supplier_code' => [
                'name'       => 'seller_id',
                'type'       => 'INT',
                'default'    => null,
            ],
            'buyer_code' => [
                'name'       => 'buyer_id',
                'type'       => 'INT',
                'default'    => null,
            ],
        ]);

        // Apply changes
        $this->forge->processIndexes('factorings');
    }

    public function down()
    {

        // Rename the columns back
        $this->forge->modifyColumn('factorings', [
            'seller_id' => [
                'name'       => 'supplier_code',
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'buyer_id' => [
                'name'       => 'buyer_code',
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
        ]);
    }
}
