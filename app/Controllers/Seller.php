<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Seller as SellerModel;
use App\Models\SellerBuyer as SellerBuyerModel;
use App\Models\Buyer as BuyerModel;
use CodeIgniter\HTTP\ResponseInterface;

class Seller extends BaseController
{
    public function index()
    {
        $model = new SellerModel();
        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
        // $data['add_class'] = $this->session->add_class;
        $data['message'] = $this->session->message;
        $data['sellers'] = $model->findAll();
        return  view('theme/head')
                .view('theme/sidebar', $data)
                .view('theme/header')
                .view('Seller/index', $data)
                .view('theme/footer');
    }

    public function add()
    {
        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
        // $data['add_class'] = $this->session->add_class;
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

    public function edit($id)
    {
        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
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

    public function update($id)
    {
        $model = new SellerModel();
        $model->update($id, $this->request->getPost());
        return redirect()->to('/seller/edit/'.$id)->with('message', 'Seller updated successfully!');
    }

    public function delete($id)
    {
        $model = new SellerModel();
        $model->delete($id);
        return redirect()->to('/seller');
    }
}
