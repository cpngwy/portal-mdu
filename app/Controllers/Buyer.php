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
    public function index()
    {
        $model = new BuyerModel();
        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
        $data['views_page'] = $this->session->views_page;
        $data['message'] = $this->session->message;
        $data['buyers'] = $model->findAll();
        return  view('theme/head')
                .view('theme/sidebar', $data)
                .view('theme/header')
                .view('Buyer/index', $data)
                .view('theme/footer');
    }

    public function add()
    {
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

    public function edit($id)
    {
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

    public function update($id)
    {
        $model = new BuyerModel();
        $model->update($id, $this->request->getPost());
        return redirect()->to('/buyer/edit/'.$id)->with('message', 'Seller updated successfully!');
    }

    public function delete($id)
    {
        $model = new BuyerModel();
        $model->delete($id);
        return redirect()->to('/buyer');
    }
}
