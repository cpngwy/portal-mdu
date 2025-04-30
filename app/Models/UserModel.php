<?php
declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class UserModel extends ShieldUserModel
{
    protected function initialize(): void
    {
        parent::initialize();

        $this->allowedFields = [
            $this->allowedFields,
            'first_name', // Added
            'last_name',  // Added
            'seller_id', // Added
            'buyer_id',  // Added
        ];
    }
}
