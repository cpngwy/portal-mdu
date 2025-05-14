<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Buyer as BuyerModel;
use App\Models\BuyerAddress as BuyerAddressModel;
use App\Models\BuyerRepresentative as BuyerRepresentativeModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class Buyer extends BaseController
{
    
    /**
     * Displays the list of buyers.
     *
     * @return string
     */
    public function index()
    {
        $data['user_group'] = $this->session->user_group ?? 'user';
        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
        $data['views_page'] = $this->session->views_page;
        $data['message'] = $this->session->message;
        return  view('theme/head')
                .view('theme/sidebar', $data)
                .view('theme/header')
                .view('Buyer/index', $data)
                .view('theme/footer');
    }

    /**
     * Shows the add form of a buyer.
     *
     * The function populates the form with the session's buyer data (if any).
     * The function also generates a random 10-digit number for the buyer code.
     * The function returns a view with the add form and the generated buyer code.
     *
     * @return string The rendered view as a string.
     */
    public function add()
    {
        $data['user_group'] = $this->session->user_group ?? 'user';
        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
        $data['views_page'] = $this->session->views_page;
        $data['message'] = $this->session->message;
        $data['buyer'] = $this->session->seller;
        $data['errors'] = $this->session->errors;
        $time = new Time();
        $data['set_buyer_code'] = sprintf('%s%s%s', 'BC', random_string('alnum', 4), $time->getTimestamp());
        return  view('theme/head')
                .view('theme/sidebar', $data)
                .view('theme/header')
                .view('Buyer/add', $data)
                .view('theme/footer');
    }

    /**
     * Validates the posted data and saves it to the database if valid.
     * 
     * If the validation fails, it redirects back to the add form with the input and validation errors.
     * If the validation succeeds, it saves the data and redirects to the add form with a success message.
     */
    public function store()
    {
        $validation = service('validation');
        $rules = [
            'buyer_code'     => 'required|is_unique[buyers.buyer_code]',
            'name'            => 'required|min_length[3]|max_length[255]',
            'piva'            => 'required|is_unique[buyers.piva]',
            'registration_id' => 'required|max_length[100]',
            'country_code'    => 'required|exact_length[2]',
            'status'          => 'required|in_list[active,inactive]',
        ];
        $data = $this->request->getPost(array_keys($rules));
        if (! $this->validateData($data, $rules)) {
            // If validation fails, return back with input and errors
            return redirect()->to('/buyer/add')
                    ->with('buyer', $this->request->getPost())
                    ->with('errors', $this->validator->getErrors());
        }
        $model = new BuyerModel();
        $model->save($this->request->getPost());
        return redirect()->to('/buyer/add')->with('message', 'Buyer added successfully!');
    }

    /**
     * Shows the edit form of a buyer.
     *
     * The function receives a buyer ID and shows the corresponding edit form.
     * The form is populated with the buyer's data from the database.
     * The function also makes a list of all addresses and representatives of the buyer.
     * The function returns a view with the edit form and the lists of addresses and representatives.
     *
     * @param int $id The ID of the buyer to be edited.
     */
    public function edit($id)
    {
        $data['user_group'] = $this->session->user_group ?? 'user';
        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
        $data['views_page'] = $this->session->views_page;
        $data['message'] = $this->session->message;
        $data['buyer'] = $this->session->buyer;
        $data['errors'] = $this->session->errors;
        $model = new BuyerModel();
        $BuyerAddress = new BuyerAddressModel();
        $BuyerRepresentatives = new BuyerRepresentativeModel(); 
        $data['buyer_addresses'] = $BuyerAddress->where('buyer_id', $id)->findAll();
        $data['buyer'] = $model->find($id);
        $data['buyer_representatives'] = $BuyerRepresentatives->where('buyer_id', $id)->findAll();
        return  view('theme/head')
                .view('theme/sidebar', $data)
                .view('theme/header')
                .view('Buyer/edit', $data)
                .view('theme/footer');
    }

    /**
     * Updates a buyer record based on the data from the edit form.
     *
     * The function receives the ID of the buyer to be updated and the data from the edit form.
     * It updates the buyer record with the new data and returns a redirect to the edit page
     * with a success message.
     *
     * @param int $id The ID of the buyer to be updated.
     */
    public function update($id)
    {
        $model = new BuyerModel();
        $model->update($id, $this->request->getPost());
        return redirect()->to('/buyer/edit/'.$id)->with('message', 'Seller updated successfully!');
    }

    /**
     * Fetches and returns a JSON-encoded list of active buyers.
     *
     * The function retrieves a list of buyers with their details such as ID, seller code, name,
     * tax identification number (PIVA), registration ID, full address, status, and creation date.
     * It filters the buyers to include only those with an 'active' status and calculates the total
     * number of active records. The data is then structured and encoded in JSON format, which is
     * outputted for use in client-side applications.
     */
    public function lists()
    {
        $model = new BuyerModel();
        $users = $model->select('id, buyer_code, name, piva, registration_id, CONCAT(address_line1," ",city," ",state," ",zip_code," ",country_code) as address, status, created_at')->where('status', 'active')->findAll();
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

    public function delete($id)
    {
        $model = new BuyerModel();
        $model->delete($id);
        return redirect()->to('/buyer');
    }
}
