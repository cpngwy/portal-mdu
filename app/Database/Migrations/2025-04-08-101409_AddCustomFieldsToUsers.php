<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Forge;
use CodeIgniter\Database\Migration;

class AddCustomFieldsToUsers extends Migration
{
    public function __construct(?Forge $forge = null)
    {
        parent::__construct($forge);

        /** @var \Config\Auth $authConfig */
        $authConfig   = config('Auth');
        $this->tables = $authConfig->tables;
    }
    public function up()
    {
        $fields = [
            'first_name' => ['type' => 'VARCHAR', 'constraint' => '20', 'after' => 'username', 'null' => true],
            'last_name' => ['type' => 'VARCHAR', 'constraint' => '20', 'after' => 'first_name','null' => true],
            'seller_code' => ['type' => 'VARCHAR', 'constraint' => '20', 'after' => 'last_name','null' => true],
            'buyer_code' => ['type' => 'VARCHAR', 'constraint' => '20', 'after' => 'seller_code','null' => true],
        ];
        $this->forge->addColumn($this->tables['users'], $fields);
    }

    public function down()
    {
        $fields = [
            'first_name',
            'last_name',
            'seller_code',
            'buyer_code',
        ];
        $this->forge->dropColumn($this->tables['users'], $fields);
    }
}
