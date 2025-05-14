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
use CodeIgniter\Shield\Authentication\Passwords;
use CodeIgniter\Shield\Authentication\Authentication;


class Users extends BaseController
{
    /**
     * The index method lists all users in the application.
     *
     * @return string
     */
    public function index()
    {
        if (!auth()->user()->inGroup('admin')) {
            return redirect()->to('no-access');
        }
        
        $users = model(UserModel::class)->findAll();
        $data['users'] = $users;
        $data['user_group'] = $this->session->user_group ?? 'user';
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

    /**
     * Assigns a role to a specified user.
     *
     * @param int $userId The ID of the user to whom the role will be assigned.
     * @param string $role The role to be assigned to the user.
     * @return \CodeIgniter\HTTP\RedirectResponse Redirects to the user edit page with a success message if the role is assigned, otherwise redirects to the no-access page.
     */

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

    /**
     * Displays the User Registration page.
     *
     * This function retrieves all sellers and buyers from the database
     * and prepares the data for rendering the user registration view.
     * It sets up necessary session data for the views, such as the user's
     * full name, active sidebar, and any session messages or errors.
     *
     * @return string The rendered view of the user registration page.
     */

    public function new()
    {
        $seller_model = new SellerModel();
        $buyer_model = new BuyerModel();
        $data['sellers'] = $seller_model->findAll();
        $data['buyers'] = $buyer_model->findAll();
        $data['title_header'] = 'User Registration';
        $data['user_group'] = $this->session->user_group ?? 'user';
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

    /**
     * Displays the User Edit page.
     *
     * This function retrieves the user with the given id from the database
     * and prepares the data for rendering the user edit view.
     * It sets up necessary session data for the views, such as the user's
     * full name, active sidebar, and any session messages or errors.
     *
     * @param int $id the id of the user to be edited
     *
     * @return string The rendered view of the user edit page.
     */
    public function edit($id)
    {
        $user = new UserModel();
        $seller_model = new SellerModel();
        $buyer_model = new BuyerModel();
        $data['user'] = $user->find($id);
        $data['sellers'] = $seller_model->findAll();
        $data['buyers'] = $buyer_model->findAll();
        $data['user_group'] = $this->session->user_group ?? 'user';
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

    /**
     * Updates the user with the given id.
     *
     * This function validates the given request data against the given rules.
     * If the validation fails, it redirects the user back to the edit user page
     * with the input data and the errors encountered during the validation.
     *
     * If the validation succeeds, it updates the user with the given data and
     * saves the user to the database.
     *
     * @param int $id the id of the user to be updated
     *
     * @return string The rendered view of the user edit page with a success message.
     */
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

    /**
     * The profile method displays the user profile page.
     *
     * This method populates the necessary session data for the view,
     * such as the user's full name, active sidebar, and any session
     * messages or errors. It sets up the user data and renders the
     * user profile view.
     *
     * @return string The rendered view of the user profile page.
     */
    public function profile()
    {
        $user = new UserModel();
        $data['user_group'] = $this->session->user_group ?? 'user';
        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
        $data['views_page'] = 'profile';
        $data['user'] = auth()->user();
        $data['error'] = $this->session->error ?? '';
        $data['message'] = $this->session->message;
        $data['errors'] = $this->session->errors;
        return  view('theme/head')
                .view('theme/sidebar', $data)
                .view('theme/header')
                .view('Users/profile', $data)
                .view('theme/footer');
    }

    /**
     * Updates the current user's password.
     *
     * This method handles the password change request for the user profile.
     * It validates the input request to ensure that the current password,
     * new password, and confirm password are provided and meet the specified
     * rules. If validation fails, it redirects back to the profile page with
     * errors. If the current password is incorrect, it redirects with an error
     * message. If successful, it updates the user's password and redirects with
     * a success message.
     */

    public function edit_profile_password()
    {
        if ($this->request->getMethod() === 'post' || $this->request->getMethod() === 'POST') {
            $rules = [
                'current_password' => 'required',
                'new_password'     => 'required|min_length[8]',
                'confirm_password' => 'required|matches[new_password]',
            ];

            if (! $this->validate($rules)) {
                return redirect()->to('/user/profile')->withInput()->with('errors', $this->validator->getErrors());
            }

            $currentPassword = $this->request->getPost('current_password');
            $newPassword     = $this->request->getPost('new_password');

            $passwordService = service('passwords');
            if (! $passwordService->verify($currentPassword, auth()->user()->password_hash)) {
                return redirect()->to('/user/profile')
                ->with('error', 'Current password is incorrect.');
            }

            auth()->user()->fill([
                'password' => $newPassword,
            ]);

            model(UserModel::class)->save(auth()->user());

            return redirect()->to('/user/profile')->with('message', 'Password updated successfully.');
        }

        
    }

    /**
     * Updates the seller and buyer of the user with the given id.
     *
     * This function validates the given request data against the given rules.
     * If the validation fails, it redirects the user back to the edit user page
     * with the input data and the errors encountered during the validation.
     *
     * If the validation succeeds, it updates the user with the given data and
     * saves the user to the database.
     *
     * @param int $id the id of the user to be updated
     *
     * @return string The rendered view of the user edit page with a success message.
     */
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

    /**
     * Handles the creation of a new user.
     *
     * This function validates the given request data against the given rules.
     * If the validation fails, it redirects the user back to the register page
     * with the input data and the errors encountered during the validation.
     *
     * If the validation succeeds, it creates a new user and saves the user to
     * the database.
     *
     * @return string The rendered view of the user edit page with a success message.
     */
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

    /**
     * Retrieves a list of users with their associated seller and buyer names, and email.
     *
     * This method queries the database to fetch user information along with related
     * seller and buyer names, and user email. It joins the users table with the sellers,
     * buyers, and auth_identities tables to gather the relevant information. The results
     * are grouped by user ID and returned as a JSON-encoded array, which includes the
     * total number of records filtered.
     */

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
