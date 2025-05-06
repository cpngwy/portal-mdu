<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Seller as SellerModel;
use App\Models\Buyer as BuyerModel;
use App\Models\userModel as UserM;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\Shield\Validation\ValidationRules;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;

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
        $data['views_page'] = 'index';
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
        return redirect()->to('user/edit/'.$userId)->with('message','Role assigned successfully');
    }

    public function new()
    {
        $seller_model = new SellerModel();
        $buyer_model = new BuyerModel();
        $data['sellers'] = $seller_model->findAll();
        $data['buyers'] = $buyer_model->findAll();
        $data['title_header'] = 'User Registration';
        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
        $data['views_page'] = 'new';
        $data['errors'] = ($this->session->errors) ? $this->session->errors : '';
        $data['error'] = ($this->session->error) ? $this->session->error : '';
        $data['message'] = ($this->session->message) ? $this->session->message : '';
        return  view('theme/head')
        .view('theme/sidebar', $data)
        .view('theme/header')
        .view('Users/new', $data)
        .view('theme/footer'); 
    }

    public function edit($id)
    {
        $user = new UserModel();
        $seller_model = new SellerModel();
        $buyer_model = new BuyerModel();
        $data['user'] = $user->find($id);
        $data['sellers'] = $seller_model->findAll();
        $data['buyers'] = $buyer_model->findAll();
        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
        $data['views_page'] = 'edit';
        $data['error'] = $this->session->error ?? '';
        $data['message'] = $this->session->message;
        $data['errors'] = $this->session->errors;
        return  view('theme/head')
                .view('theme/sidebar', $data)
                .view('theme/header')
                .view('Users/edit', $data)
                .view('theme/footer');
    }

    public function update($id)
    {
        $validation = service('validation');
        $rules = [
            'password'     => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->to('/user/edit/'.$id)->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $users = auth()->getProvider();
        $user = $users->findById($id);
        $user->fill([
            'password' => $this->request->getPost('password'),
        ]);
        $users->save($user);
        return redirect()->to('/user/edit/'.$id)->withInput()->with('message', 'User updated successfully!');
    }

    public function update_seller_buyer($id)
    {
        $validation = service('validation');
        $rules = [
            'seller_id'     => 'required',
        ];
        $data = $this->request->getPost(array_keys($rules));
        if (!$this->validateData($data, $rules)) {
            return redirect()->to('/user/edit/'.$id)
                    ->with('errors', $this->validator->getErrors());
        }
        $user = new UserM();
        $update_data = ['seller_id' => $this->request->getPost('seller_id')];
        $user->update($id, $update_data);
        return redirect()->to('/user/edit/'.$id)->with('message', 'User updated successfully!');
    }

    public function register_user()
    {
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

        try {
            $users->save($user);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }
        // To get the complete user object with ID, we need to get from the database
        $user = $users->findById($users->getInsertID());
        // Add to default group
        $users->addToDefaultGroup($user);
        return redirect()->to('users/new')->with('message','User has been created.');

    }

    public function lists()
    {
        $model = new UserModel();
        $users = $model->select('users.id, first_name as first_name, last_name as last_name, sellers.name seller_name, buyers.name buyer_name, auth_identities.secret email')
                ->join('sellers', 'sellers.id = users.seller_id', 'left')
                ->join('buyers', 'buyers.id = users.buyer_id', 'left')
                ->join('auth_identities', 'auth_identities.user_id = users.id', 'left')
                ->groupBy('users.id')
                ->findAll();
        $TotalRecords = $model->groupBy('users.id')->countAllResults();
        $data['recordsFiltered'] = $TotalRecords;
        $data['data'] = [];
        $x = 0;
        foreach($users as $key => $value):

            $data['data'][$key] = $value;
        $x++;
        endforeach;
        echo json_encode($data);
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
