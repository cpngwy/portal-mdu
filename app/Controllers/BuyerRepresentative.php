<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BuyerRepresentative as BuyerRepresentativeModel;
use CodeIgniter\HTTP\ResponseInterface;

class BuyerRepresentative extends BaseController
{
    public function index()
    {
        //
    }

    public function store($buyer_id)
    {
        $validation = service('validation');
        $rules = [
            'first_name'   => 'required|min_length[3]|max_length[100]',
            'last_name'    => 'required|min_length[3]|max_length[100]',
            'email'        => 'required|valid_email',
            'type'         => 'required|in_list[owner,authorized_person]',
        ];
        $data = $this->request->getPost(array_keys($rules));
        if (! $this->validateData($data, $rules)) {
            // If validation fails, return back with input and errors
            return redirect()->to('/buyer/edit/'.$buyer_id)
                    ->with('errors', $this->validator->getErrors());
        }
        $data['buyer_id'] = $buyer_id;
        foreach ($this->request->getPost() as $key => $value):
            $data[$key] = $value;
        endforeach;

        $BuyerRepresentative = new BuyerRepresentativeModel();
        $BuyerRepresentative->insert($data);
        return redirect()->to('/buyer/edit/'.$buyer_id)->with('message', 'Buyer representative added successfully.');
    }
}
