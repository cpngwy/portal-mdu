<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\Factoring;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    public function index()
    {
        // Ensure user is authenticated
        if (!auth()->loggedIn()) {
            return redirect()->to('login');
        }

        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
        $data['get_gross_amount_monthly'] = $this->get_gross_amount_monthly();
        $data['approved_percent'] = $this->get_percentage('approved');
        $data['declined_percent'] = $this->get_percentage('declined');
        $data['pending_percent'] = $this->get_percentage('pending');
        $data['processing_percent'] = $this->get_percentage('processing');

        $data['views_page'] = 'index';
        return  view('theme/head')
                .view('theme/sidebar', $data)
                .view('theme/header')
                .view('Dashboard/index', $data)
                .view('theme/footer');
    }

    public function gross_amount_monthly()
    {
        for($x=1; $x<=12; $x++)
        {
            $y = $x-1;
            $amount[$y] = $this->sum_transaction($this->session->user['seller_id'], date('Y').'-0'.$x.'-01', date('Y').'-0'.$x.'-31 23:59:59', 'factoring', 'approved');
        }
        return json_encode($amount);
    }

    public function status_percentage()
    {
        $percentage[0] = $this->get_percentage('pending');
        $percentage[1] = $this->get_percentage('processing');
        $percentage[2] = $this->get_percentage('approved');
        $percentage[3] = $this->get_percentage('declined');
        return json_encode($percentage);
    }

    private function get_gross_amount_monthly()
    {
        $factoring = new Factoring();
        return $factoring->get_gross_amount_monthly($this->session->user['seller_id']);
    }

    private function get_percentage($type)
    {
        $factoring = new Factoring();
        $total_records = $factoring->select('COUNT(status) as total')->where('seller_id', $this->session->user['seller_id'])->groupBy('seller_id')->first();
        $percentage = $factoring->get_percentage($this->session->user['seller_id'], $type, $total_records['total']);
        return number_format($percentage['percentage'], 3) ??  0.00;
    }

    private function sum_transaction($seller_id, $start, $end, $type, $status)
    {
        $factoring = new Factoring();
        
        if(empty($status)):
        
            $query = $factoring->select('SUM(gross_amount_cents) as gross_amount_cents')
            ->where(plural($type).'.seller_id', $seller_id)
            ->where(plural($type).'.created_at >=', $start)
            ->where(plural($type).'.created_at <=', $end)->first();
            return $query['gross_amount_cents'] ?? 0.00;

        endif;

        $query = $factoring->select('SUM(gross_amount_cents) as gross_amount_cents')
        ->where(plural($type).'.seller_id', $seller_id)
        ->where(plural($type).'.status', $status)
        ->where(plural($type).'.created_at >=', $start)
        ->where(plural($type).'.created_at <=', $end)->first();
        return $query['gross_amount_cents'] ?? 0.00;
    }
}