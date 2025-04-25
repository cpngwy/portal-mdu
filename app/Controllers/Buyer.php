<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Buyer as BuyerModel;
use CodeIgniter\HTTP\ResponseInterface;

class Buyer extends BaseController
{
    public function index()
    {
        $model = new BuyerModel();
        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
        // $data['add_class'] = $this->session->add_class;
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
        // $data['add_class'] = $this->session->add_class;
        $data['message'] = $this->session->message;
        if($this->session->seller):
            $data['buyer'] = $this->session->seller;
        endif;
        if($this->session->errors):
            $data['errors'] = $this->session->errors;
        endif;
        $data['set_buyer_code'] = 'BC'.random_string('numeric', 10);
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
            'buyer_code'     => 'required|min_length[3]|max_length[100]',
            'name'            => 'required|min_length[3]|max_length[255]',
            'piva'            => 'required|max_length[50]',
            'registration_id' => 'required|max_length[100]',
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
        $data['message'] = $this->session->message;
        $data['buyer'] = $this->session->buyer;
        $data['errors'] = $this->session->errors;
        $model = new BuyerModel();
        $data['buyer'] = $model->find($id);
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
