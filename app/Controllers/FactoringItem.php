<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FactoringItem as FactoringItemModel;
use CodeIgniter\HTTP\ResponseInterface;

class FactoringItem extends BaseController
{
    public function store($factoring_id)
    {   
        $validation = service('validation');
        $rules = [
            'discount_cents'        => 'required|decimal',
            'shipping_price_cents'  => 'required|decimal',
            'external_reference_id' => 'required|min_length[3]',
            'title'                 => 'required|min_length[3]',
            'net_price_per_item_cents' => 'required|decimal',
            'item_tax_cents'        => 'required|decimal',
            'quantity'              => 'required|integer',
            'net_price_cents'       => 'required|decimal'
        ];
        $data = $this->request->getPost(array_keys($rules));
        if (! $this->validateData($data, $rules)) {
            // If validation fails, return back with input and errors
            return redirect()->to('/factoring/edit/'.$factoring_id)
                    ->with('errors', $this->validator->getErrors());
        }
        $model = new FactoringItemModel();
        $data['factoring_id'] = $factoring_id;
        foreach ($this->request->getPost() as $key => $value) 
        {
            
            $data[$key] = $value;
            
        }
        $model->save($data);
        return redirect()->to('/factoring/edit/'.$factoring_id);
    }
}
