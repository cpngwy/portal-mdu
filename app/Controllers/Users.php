<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Auth;

class Users extends BaseController
{
    public function index()
    {
        if (!auth()->user()->inGroup('admin')) {
            return redirect()->to('no-access');
        }
        
        $users = model(UserModel::class)->findAll();
        $data['users'] = $users;
        $data['add_class'] = $this->session->add_class;
        $data['message'] = $this->session->message;
        $data['title_header'] = 'Users';
        return  view('theme/head')
                .view('theme/sidebar')
                .view('theme/header')
                .view('Users/index', $data)
                .view('theme/footer');
    }

    public function assignRole($userId, $role)
    {
        if (!auth()->user()->inGroup('admin')) {
            return redirect()->to('no-access');
        }
        
        $user = auth()->getProvider()->findById($userId);
        if ($user) {
            $user->addGroup($role);
        }
        return redirect()->to('admin/users')->with('message','Role assigned successfully')->with('add_class','bg-success');
    }

    public function register()
    {
        $userModel = auth()->getProvider();

        $newUser = new User([
            'username' => 'foo-bar',
            'email'    => '[email protected]',
            'password' => 'secret plain text password',
        ]);

        $userModel->save($newUser);

        $savedUser = $userModel->findById($userModel->getInsertID());

        $userModel->addToDefaultGroup($savedUser);
    }
}
