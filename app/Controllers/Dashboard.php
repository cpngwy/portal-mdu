<?php

namespace App\Controllers;

use App\Controllers\BaseController;
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
        return  view('theme/head')
                .view('theme/sidebar', $data)
                .view('theme/header')
                .view('Dashboard/index', $data)
                .view('theme/footer');
    }
}
