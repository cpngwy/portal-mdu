<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Factoring as FactoringModel;
use App\Models\Seller as SellerModel;
use App\Models\Buyer as BuyerModel;
use App\Models\BuyerAddress as BuyerAddressModel;
use App\Models\BuyerRepresentative as BuyerRepresentativeModel;
use App\Models\FactoringItem as FactoringItemModel;
use App\Models\SellerBuyer as SellerBuyerModel;
use GuzzleHttp\Client;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class Factoring extends BaseController
{
    public function index()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('login');
        }

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
        $seller_model = new SellerModel();
        $buyer_model = new BuyerModel();
        $seller_buyer_model = new SellerBuyerModel();
        $time = new Time();
        $invoice_external_reference_id = $time->getYear().$time->getMonth().$time->getDay().'_'.random_string('alnum', 6).$time->getTimestamp();
        $data['views_page'] = $this->session->views_page;
        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
        $data['factoring'] = $this->session->factoring;
        // $data['add_class'] = $this->session->add_class;
        $data['message'] = $this->session->message;
        $data['errors'] = $this->session->errors;
        $data['invoice_external_reference_id'] = $invoice_external_reference_id;
        $data['sellers'] = $seller_model->where('id', $this->session->user_details['seller_id'])->findAll();
        $data['buyers'] =  $seller_buyer_model->select('*, buyers.buyer_code')->join('buyers', 'buyers.id = buyer_id')->where('seller_id', $this->session->user_details['seller_id'])->findAll();
        return  view('theme/head')
        .view('theme/sidebar', $data)
        .view('theme/header')
        .view('Factoring/create', $data)
        .view('theme/footer');
    }

    public function store()
    {   
        $validation = service('validation');
        $rules = [
            'supplier_code'     => 'required|min_length[3]|max_length[50]',
            'buyer_code'        => 'required|min_length[3]|max_length[50]',
            'invoice_external_reference_id' => 'required|min_length[10]|max_length[255]',
            'language'          => 'required|max_length[2]',
            'payment_method'    => 'required|max_length[50]',
            // 'invoice_issued_at' => 'required|valid_date',
            'total_discount_cents'    => 'required|numeric',
            'gross_amount_cents'      => 'required|numeric',
            'currency'          => 'required|max_length[3]',
            'net_term'        => 'required|numeric'
        ];
        $data = $this->request->getPost(array_keys($rules));
        if (! $this->validateData($data, $rules)) {
            // If validation fails, return back with input and errors
            return redirect()->to('/factoring/create')
                    ->with('factoring', $this->request->getPost())
                    ->with('errors', $this->validator->getErrors());
        }
        $model = new FactoringModel();
        $data = [];
        foreach ($this->request->getPost() as $key => $value) 
        {
            if($key === 'invoice_issued_at'):
                $data[$key] = $this->toDateTimeString($value);
            else:
                $data[$key] = $value;
            endif;
            
        }
        $model->save($data);
        return redirect()->to('/factoring/edit/'.$model->getInsertID())->with('message', 'Factoring has been created, add items and continue.');
    }

    public function edit($id)
    {
        $model = new FactoringModel();
        $seller_model = new SellerModel();
        $buyer_model = new BuyerModel();
        $buyer_address_model = new BuyerAddressModel();
        $buyer_representative_model = new BuyerRepresentativeModel();
        $factoringItem_model = new FactoringItemModel();
        
        $data['views_page'] = $this->session->views_page;
        $data['factoring'] = $model->find($id);
        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
        $data['message'] = $this->session->message;
        $data['errors'] = $this->session->errors;
        $data['sellers'] = $seller_model->findAll();
        $data['buyers'] = $buyer_model->findAll();
        $data['factoring_items'] = $factoringItem_model->where('factoring_id', $id)->findAll();
        $data['factoring_items_count'] = $factoringItem_model->where('factoring_id', $id)->countAllResults();
        $buyer_data = $buyer_model->where('buyer_code', $data['factoring']['buyer_code'])->first();
        $data['buyer_address_billing'] = $buyer_address_model->where('buyer_id', $buyer_data['id'])->where('type', 'billing')->where('status', 'Active')->findAll();
        $data['buyer_address_shipping'] = $buyer_address_model->where('buyer_id', $buyer_data['id'])->where('type', 'shipping')->where('status', 'Active')->findAll();
        $data['buyer_representative'] = $buyer_representative_model->where('buyer_id', $buyer_data['id'])->where('status', 'Active')->findAll();
        return  view('theme/head')
        .view('theme/sidebar', $data)
        .view('theme/header')
        .view('Factoring/edit', $data)
        .view('theme/footer');
    }

    public function update($id)
    {
        $validation = service('validation');
        $rules = [
            'invoice_issued_at' => 'required|valid_date',
        ];
        $data = $this->request->getPost(array_keys($rules));
        if (! $this->validateData($data, $rules)) {
            return redirect()->to('/factoring/edit/'.$id)
                    ->with('errors', $this->validator->getErrors());
        }
        $model = new FactoringModel();
        $buyer_model = new BuyerModel();
        $buyer_address_model = new BuyerAddressModel();
        $buyer_representative_model = new BuyerRepresentativeModel();
        $data = $this->request->getPost();
        $data['owner_is_authorized'] = $this->request->getPost('owner_is_authorized') === 'on' ? 1 : 0;
        $model->update($id, $data);
        $factoring = $model->find($id);
        $factoringItem_model = new FactoringItemModel();
        $factoring_items = $factoringItem_model->where('factoring_id', $id)->findAll();
        // body_parameters
        $body_param['invoice_external_reference_id'] = $factoring['invoice_external_reference_id'];
        $body_param['currency'] = $factoring['currency'];
        $body_param['net_term'] = $factoring['net_term'];
        $body_param['payment_method'] = $factoring['payment_method'];
        $body_param['total_discount_cents'] = $factoring['total_discount_cents'] * 100;
        // $body_param['invoice_issued_at'] = $factoring['invoice_issued_at'];
        $body_param['gross_amount_cents'] = $factoring['gross_amount_cents'] * 100;
        $body_param['language'] = $factoring['language'];
        // $body_param['invoice_url'] = $factoring['invoice_url'];
        // $filePath = FCPATH.'uploads/Invoice_2023102501.pdf';//fopen($filePath, 'r');
        // $body_param['file'] = $filePath;
        // Get buyer details
        $buyer_details = $buyer_model->where('buyer_code', $factoring['buyer_code'])->first();
        // lines parameters
        $lines = ["lines" => [[
            "line_items" => [["quantity" => $factoring_items[0]['quantity'], "external_reference_id" => $factoring_items[0]['external_reference_id'], "title" => $factoring_items[0]['title'], "net_price_per_item_cents" => $factoring_items[0]['net_price_per_item_cents'] * 100, "tax_cents" => $factoring_items[0]['item_tax_cents'] * 100, "net_price_cents" => $factoring_items[0]['net_price_cents'] * 100]],
            "discount_cents" => $factoring_items[0]['discount_cents'] * 100, "shipping_price_cents" => $factoring_items[0]['shipping_price_cents'] * 100,
        ]]];
        
        // billing parameters
        $billing = [];
        $buyer_address_details = $buyer_address_model->where('buyer_id', $buyer_details['id'])->where('type', 'billing')->where('status', 'Active')->first();
        foreach($buyer_address_details as $key => $value):
            if(in_array($key, ['country_code', 'state', 'city', 'zip_code', 'address_line1', 'address_line2'])):
                $billing['billing_address'][$key] = $value;
            endif;
        endforeach;

        // shipping parameters
        $shipping = [];
        $buyer_address_details = $buyer_address_model->where('buyer_id', $buyer_details['id'])->where('type', 'shipping')->where('status', 'Active')->first();
        foreach($buyer_address_details as $key => $value):
            if(in_array($key, ['country_code', 'state', 'city', 'zip_code', 'address_line1', 'address_line2'])):
                $shipping['shipping_address'][$key] = $value;
            endif;
        endforeach;

        // buyer parameters
        $buyer = [];
        foreach($buyer_details as $key => $value):
            if(in_array($key, ['name', 'registration_id', 'buyer_code'])):
                $buyer['buyer'][($key == 'buyer_code') ? 'external_reference_id' : $key] = $value;
            endif;
        endforeach;

        $buyer_representative_details = $buyer_representative_model->where('buyer_id', $buyer_details['id'])->first();
        foreach($buyer_representative_details as $key => $value):
            if(in_array($key, ['first_name', 'last_name', 'email'])):
                $buyer['buyer'][$key] = $value;
            endif;
        endforeach;

        // owner parameters
        $owner = ["owners" => [[
                "is_authorized" => true,
                "first_name"    => $buyer_representative_details['first_name'],
                "last_name"     => $buyer_representative_details['first_name']
        ]]];

        $final_parameters = array_merge($body_param, $lines, $buyer, $billing, $shipping, $owner);
        $seller_model = new SellerModel();
        $seller_details = $seller_model->where('seller_code', $factoring['supplier_code'])->first();
        $send = $this->sendPost($seller_details['api_key'], json_encode($final_parameters));
        if($send['status_code'] != 200):
            return redirect()->to('/factoring/edit/'.$id)
            ->with('parameters', json_encode($final_parameters))
            ->with('response', $send)
            ->with('errors', $send['data']);
        endif;
        return redirect()->to('/factoring/edit/'.$id)
        ->with('parameters', json_encode($final_parameters))
        ->with('response', $send['data'])
        ->with('message', 'Factoring has been updated!');
    }

    private function toDateTimeString($from_data)
    {
        $time = Time::parse($from_data);
        return $time->toDateTimeString();
    }


    private function sendPost($api_key, $body)
    {
        $client = new Client();
        try {
            $response = $client->request('POST', getenv('MONDU_ENDPOINT').'/factorings', [
                'headers' => [
                    'Api-Token' => $api_key,
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                ],
                'body' => $body,
            ]);
            if(!in_array($response->getStatusCode(),[200, 201, 202])):
                $responseBody = json_decode($response->getBody()->getContents());
                return [
                    "status_code" => $response->getStatusCode(),
                    "data" => $responseBody->errors,
                ];
            endif;
            return [
                "status_code" => $response->getStatusCode(),
                "data" => $response->getBody()->getContents()
            ];
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $responseBody = json_decode($response->getBody()->getContents());
                if(!in_array($response->getStatusCode(),[200, 201, 202])):
                    return [
                        "status_code" => $response->getStatusCode(),
                        "data" => $responseBody->errors,
                    ];
                endif;
                return [
                    "status_code" => $response->getStatusCode(),
                    "data" => $responseBody,
                ];
            }
            $responseBody = json_encode(['message' => $e->getMessage()]);
            return [
                "status_code" => $e->getCode(),
                "data" => $responseBody
            ];
        }
    }
}