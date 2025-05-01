<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use CodeIgniter\Shield\Entities\User;
// use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\Shield\Validation\ValidationRules;

class Users extends BaseController
{
    public function index()
    {
        if (!auth()->user()->inGroup('admin')) {
            return redirect()->to('no-access');
        }
        
        $users = model(UserModel::class)->findAll();
        $data['users'] = $users;
        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
        $data['views_page'] = $this->session->views_page;
        $data['add_class'] = $this->session->add_class;
        $data['message'] = $this->session->message;
        $data['title_header'] = 'Users';
        return  view('theme/head')
                .view('theme/sidebar', $data)
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
        return redirect()->to('users')->with('message','Role assigned successfully')->with('add_class','bg-success');
    }

    public function new()
    {
        $data['title_header'] = 'User Registration';
        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
        $data['views_page'] = $this->session->views_page;
        $data['errors'] = ($this->session->errors) ? $this->session->errors : '';
        $data['error'] = ($this->session->error) ? $this->session->error : '';
        $data['message'] = ($this->session->message) ? $this->session->message : '';
        return  view('theme/head')
        .view('theme/sidebar', $data)
        .view('theme/header')
        .view('Users/new', $data)
        .view('theme/footer'); 
    }

    public function register_user()
    {
        // Check if registration is allowed
        // if (! setting('Auth.allowRegistration')) {
        //     return redirect()->back()->withInput()
        //         ->with('error', lang('Auth.registerDisabled'));
        // }

        $users = $this->getUserProvider();

        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        $rules = $this->getValidationRules();

        if (! $this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Save the user
        $allowedPostFields = array_keys($rules);
        $user              = $this->getUserEntity();
        $user->fill($this->request->getPost($allowedPostFields));

        // // Workaround for email only registration/login
        // if ($user->username === null) {
        //     $user->username = null;
        // }

        try {
            $users->save($user);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }
        // To get the complete user object with ID, we need to get from the database
        $user = $users->findById($users->getInsertID());
        // Add to default group
        $users->addToDefaultGroup($user);
        return redirect()->to('users/new')->with('message','User has been created.')->with('add_class','bg-success');

    }

    /**
     * Returns the User provider
     */
    protected function getUserProvider(): UserModel
    {
        $provider = model(setting('Auth.userProvider'));

        assert($provider instanceof UserModel, 'Config Auth.userProvider is not a valid UserProvider.');

        return $provider;
    }

    /**
     * Returns the Entity class that should be used
     */
    protected function getUserEntity(): User
    {
        return new User();
    }

    /**
     * Returns the rules that should be used for validation.
     *
     * @return array<string, array<string, list<string>|string>>
     */
    protected function getValidationRules(): array
    {
        $rules = new ValidationRules();

        return $rules->getRegistrationRules();
    }
}
