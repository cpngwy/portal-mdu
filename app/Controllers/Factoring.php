<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Factoring as FactoringModel;
use CodeIgniter\HTTP\ResponseInterface;

class Factoring extends BaseController
{
    public function index()
    {
        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
        // $data['add_class'] = $this->session->add_class;
        $data['message'] = $this->session->message;
        $model = new FactoringModel();
        $data['factorings'] = $model->findAll();
        return  view('theme/head')
        .view('theme/sidebar', $data)
        .view('theme/header')
        .view('Factoring/index', $data)
        .view('theme/footer');
    }

    public function create()
    {
        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
        // $data['add_class'] = $this->session->add_class;
        $data['message'] = $this->session->message;
        return  view('theme/head')
        .view('theme/sidebar', $data)
        .view('theme/header')
        .view('Factoring/create', $data)
        .view('theme/footer');
    }

    public function store()
    {
        $model = new FactoringModel();
        $data = $this->request->getPost();
        $data['owner_is_authorized'] = $this->request->getPost('owner_is_authorized') === 'on' ? 1 : 0;
        $model->save($data);
        return redirect()->to('/factoring')->with('message', 'Factoring has been submitted!');
    }

    public function edit($id)
    {
        $model = new FactoringModel();
        $data['factoring'] = $model->find($id);
        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
        $data['message'] = $this->session->message;
        return  view('theme/head')
        .view('theme/sidebar', $data)
        .view('theme/header')
        .view('Factoring/edit', $data)
        .view('theme/footer');
    }

    public function update($id)
    {
        $model = new FactoringModel();
        $data = $this->request->getPost();
        $data['owner_is_authorized'] = $this->request->getPost('owner_is_authorized') === 'on' ? 1 : 0;
        $model->update($id, $data);
        return redirect()->to('/factoring')->with('message', 'Factoring has been updated!');
    }
}
