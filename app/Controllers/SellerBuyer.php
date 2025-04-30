<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SellerBuyer as SellerBuyerModel;
use App\Models\Buyer as BuyerModel;
use CodeIgniter\HTTP\ResponseInterface;

class SellerBuyer extends BaseController
{
    public function index()
    {
        //
    }

    public function store($seller_id)
    {
        $validation = service('validation');
        $rules = [
            'status' => 'required|in_list[Active,Inactive]',
        ];
        $data = $this->request->getPost(array_keys($rules));
        if (! $this->validateData($data, $rules)) {
            return redirect()->to('/seller/edit/'.$seller_id)
                    ->with('errors', $this->validator->getErrors());
        }
        $SellerBuyerModel = new SellerBuyerModel();
        $check = $SellerBuyerModel->where('seller_id', $seller_id)->where('buyer_id', $this->request->getPost('buyer_id'))->first();
        if(empty($check)):
            $BuyerModel = new BuyerModel();
            $seller_buyer_data['seller_id'] = $seller_id;
            $seller_buyer_data['buyer_id'] = $this->request->getPost('buyer_id');
            $seller_buyer_data['status'] = $this->request->getPost('status');
            $seller_fields = ['name', 'piva', 'registration_id', 'country_code'];
            foreach($BuyerModel->find($this->request->getPost('buyer_id')) as $key => $value):
                if(in_array($key, $seller_fields)):
                    $seller_buyer_data[$key] = $value;
                endif;
            endforeach;
            $SellerBuyerModel->insert($seller_buyer_data);
            $message = 'Buyer added successfully.';
        else:
            $message = 'Buyer already added.';
        endif;
        
        return redirect()->to('/seller/edit/'.$seller_id)->with('message', $message);
    }
}
