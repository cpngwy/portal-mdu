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
        $this->session->set('approved_percent', $data['approved_percent']);
        $this->session->set('declined_percent', $data['declined_percent']);
        $this->session->set('pending_percent', $data['pending_percent']);
        $this->session->set('processing_percent', $data['processing_percent']);
        $data['views_page'] = 'index';
        return  view('theme/head')
                .view('theme/sidebar', $data)
                .view('theme/header')
                .view('Dashboard/index', $data)
                .view('theme/footer');
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
        return (isset($percentage['percentage'])) ? number_format($percentage['percentage'], 2) : 0.00;
    }   
}
