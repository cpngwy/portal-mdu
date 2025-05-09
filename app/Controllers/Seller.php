<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Seller as SellerModel;
use App\Models\SellerBuyer as SellerBuyerModel;
use App\Models\Buyer as BuyerModel;
use CodeIgniter\HTTP\ResponseInterface;

class Seller extends BaseController
{
    /**
     * Shows the list of sellers.
     *
     * The function retrieves the list of all sellers from the database and
     * stores it in the session.
     * The function returns a view with the list of sellers.
     *
     * @return string The rendered view as a string.
     */
    public function index()
    {

        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
        $data['views_page'] = $this->session->views_page;
        $data['message'] = $this->session->message;
        return  view('theme/head')
                .view('theme/sidebar', $data)
                .view('theme/header')
                .view('Seller/index', $data)
                .view('theme/footer');
    }

    /**
     * Shows the add form of a seller.
     *
     * The function populates the form with the session's seller data (if any).
     * The function also generates a random 10-digit number for the seller code.
     * The function returns a view with the add form and the generated seller code.
     *
     * @return string The rendered view as a string.
     */
    public function add()
    {
        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
        $data['views_page'] = $this->session->views_page;
        $data['message'] = $this->session->message;
        if($this->session->seller):
            $data['seller'] = $this->session->seller;
        endif;
        if($this->session->errors):
            $data['errors'] = $this->session->errors;
        endif;
        $data['set_seller_code'] = random_string('numeric', 10);
        return  view('theme/head')
                .view('theme/sidebar', $data)
                .view('theme/header')
                .view('Seller/add', $data)
                .view('theme/footer');
    }

    /**
     * Add a new seller
     *
     * Validates the input data and saves a new seller to the database.
     * If validation fails, redirects back to the add form with input and errors.
     * If validation succeeds, redirects back to the add form with a success message.
     *
     * @return ResponseInterface
     */
    public function store()
    {
        $validation = service('validation');
        $rules = [
            'seller_code'     => 'required|min_length[3]|max_length[100]',
            'name'            => 'required|min_length[3]|max_length[255]',
            'piva'            => 'required|max_length[50]',
            'registration_id' => 'required|max_length[100]',
            'api_key'         => 'required|max_length[255]',
            'country_code'    => 'required|max_length[2]',
            'city'            => 'required|max_length[50]',
            'state'           => 'required|max_length[50]',
            'zip_code'        => 'required|max_length[50]',
            'address_line1'   => 'required|max_length[255]',
            'status'          => 'required|in_list[active,inactive]',
        ];
        $data = $this->request->getPost(array_keys($rules));
        if (! $this->validateData($data, $rules)) {
            // If validation fails, return back with input and errors
            return redirect()->to('/seller/add')
                    ->with('seller', $this->request->getPost())
                    ->with('errors', $this->validator->getErrors());
        }
        $model = new SellerModel();
        $model->save($this->request->getPost());
        return redirect()->to('/seller/add')->with('message', 'Seller added successfully!');
    }

    /**
     * Shows the edit form of a seller.
     *
     * The function receives a seller ID and shows the corresponding edit form.
     * The form is populated with the seller's data from the database.
     * The function also makes a list of all buyers available for the seller-buyer
     * relationship.
     * The function returns a view with the edit form and the list of buyers.
     *
     * @param int $id The ID of the seller to be edited.
     */
    public function edit($id)
    {
        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
        $data['views_page'] = $this->session->views_page;
        $data['message'] = $this->session->message;
        $data['seller'] = $this->session->seller;
        $data['errors'] = $this->session->errors;
        $model = new SellerModel();
        $SellerBuyerModel = new SellerBuyerModel();
        $BuyerModel = new BuyerModel();
        $data['seller'] = $model->find($id);
        $data['seller_buyers'] = $SellerBuyerModel->where('seller_id', $id)->findAll();
        $data['buyers'] = $BuyerModel->findAll();
        return  view('theme/head')
                .view('theme/sidebar', $data)
                .view('theme/header')
                .view('Seller/edit', $data)
                .view('theme/footer');
    }

    /**
     * Updates a seller record and returns a redirect response with a success message.
     *
     * The function receives a seller ID and updates the corresponding record in the database
     * with the values from the current request. It then redirects the user to the URL
     * '/seller/edit/$id' with a success message.
     */
    public function update($id)
    {
        $model = new SellerModel();
        $model->update($id, $this->request->getPost());
        return redirect()->to('/seller/edit/'.$id)->with('message', 'Seller updated successfully!');
    }

    /**
     * Fetches and returns a JSON-encoded list of active sellers.
     *
     * The function retrieves a list of sellers with their details such as ID, seller code, name,
     * tax identification number (PIVA), registration ID, full address, status, and creation date.
     * It filters the sellers to include only those with an 'active' status and calculates the total
     * number of active records. The data is then structured and encoded in JSON format, which is
     * outputted for use in client-side applications.
     */
    public function lists()
    {
        $model = new SellerModel();
        $users = $model->select('id, seller_code, name, piva, registration_id, CONCAT(address_line1," ",city," ",state," ",zip_code," ",country_code) as address, status, created_at')->where('status', 'active')->findAll();
        $TotalRecords = $model->groupBy('id')->countAllResults();
        $data['recordsFiltered'] = $TotalRecords;
        $data['data'] = [];
        $x = 0;
        foreach($users as $key => $value):

            $data['data'][$key] = $value;
        $x++;
        endforeach;
        echo json_encode($data);
    }
}
