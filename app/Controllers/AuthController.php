<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Auth; 

class AuthController extends BaseController
{
    public function logout()
    {
        auth()->logout();
        return redirect()->to('login');
    }
    
    public function noAccess()
    {
        return view('Auth/no_access');
    }
}
