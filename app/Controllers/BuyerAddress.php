<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BuyerAddress as BuyerAddressModel;
use CodeIgniter\HTTP\ResponseInterface;

class BuyerAddress extends BaseController
{
    public function index()
    {
        //
    }
    public function store($buyer_id)
    {
        $data['buyer_id'] = $buyer_id;
        foreach ($this->request->getPost() as $key => $value):
            $data[$key] = $value;
        endforeach;
        $addressModel = new BuyerAddressModel();
        $addressModel->insert($data);

        return redirect()->to('/buyer/edit/'.$buyer_id)->with('message', 'Buyer '.$this->request->getPost('type').' address added successfully.');
    }
}
