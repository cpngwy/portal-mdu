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
        
        // Ensure user has admin role
        // if (!auth()->user()->inGroup('admin')) {
        //     return redirect()->to('no-access');
        // }
        
        return  view('theme/head')
                .view('theme/sidebar')
                .view('theme/header')
                .view('Dashboard/index')
                .view('theme/footer');
    }
}
