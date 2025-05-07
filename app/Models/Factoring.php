<?php

namespace App\Models;

use CodeIgniter\Model;

class Factoring extends Model
{
    protected $table            = 'factorings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'seller_id', 'buyer_id', 'invoice_external_reference_id', 'currency',
        'net_term', 'payment_method', 'total_discount_cents', 'invoice_issued_at',
        'gross_amount_cents', 'language', 'invoice_url', 'file',
        'owner_first_name', 'owner_last_name', 'owner_is_authorized', 'status', 
        'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = '';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function get_gross_amount_monthly($seller_id)
    {
        $start_date = "DATE_FORMAT(NOW() ,'%Y-%m-01')";
        $end_date = "NOW()";
        $get_gross = $this->select('SUM(gross_amount_cents) as gross_amount_cents')
            ->where('seller_id', $seller_id)
            ->where('created_at >', $start_date)
            ->where('created_at >', $end_date)
            ->groupBy('seller_id')
            ->first();
        return number_format($get_gross['gross_amount_cents'], 2);
    }

    public function get_percentage($seller_id, $type, $total_records)
    {
        $get_percentage = $this->select("(COUNT(status) / $total_records) * 100 AS percentage")
            ->where('seller_id', $seller_id)
            ->where('status', $type)
            ->groupBy('seller_id')
            ->first();
        return $get_percentage;
    }
}
