<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\FileUpload;
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
    /**
     * The index method is responsible for rendering the index view, which displays the list of
     * all factorings. It first checks if the user is logged in, if not it redirects to the login page.
     * Then it sets up the data to be passed to the view, including the user's full name,
     * the active sidebar item, the page being viewed, and the message to be displayed.
     * Finally, it renders the view.
     * @return ResponseInterface the rendered view
     */
    public function index()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('login');
        }

        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
        $data['views_page'] = 'index';
        $data['message'] = $this->session->message;
        $model = new FactoringModel();
        $data['factorings'] = $model->findAll();
        return  view('theme/head')
        .view('theme/sidebar', $data)
        .view('theme/header')
        .view('Factoring/index', $data)
        .view('theme/footer');
    }

    /**
     * The create method is responsible for rendering the create view, which displays the form to add a new factoring.
     * It first checks if the user is logged in, if not it redirects to the login page.
     * Then it sets up the data to be passed to the view, including the user's full name,
     * the active sidebar item, the page being viewed, the message to be displayed, and the errors to be displayed.
     * It also sets up the sellers and buyers to be displayed in the form.
     * Finally, it renders the view.
     * @return ResponseInterface the rendered view
     */
    public function create()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('login');
        }

        $seller_model = new SellerModel();
        $buyer_model = new BuyerModel();
        $seller_buyer_model = new SellerBuyerModel();
        $time = new Time();
        $invoice_external_reference_id = sprintf('%s%s%s_%s%s', $time->getYear(), $time->getMonth(), $time->getDay(), random_string('alnum', 6), $time->getTimestamp());
        $data['views_page'] = $this->session->views_page;
        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
        $data['factoring'] = $this->session->factoring;
        $data['message'] = $this->session->message;
        $data['errors'] = $this->session->errors;
        $data['invoice_external_reference_id'] = $invoice_external_reference_id;
        $data['sellers'] = $seller_model->where('id', $this->session->user['seller_id'])->findAll();
        $data['buyers'] =  $seller_buyer_model->select('*, buyers.buyer_code')->join('buyers', 'buyers.id = buyer_id')->where('seller_id', $this->session->user['seller_id'])->findAll();
        return  view('theme/head')
        .view('theme/sidebar', $data)
        .view('theme/header')
        .view('Factoring/create', $data)
        .view('theme/footer');
    }

    /**
     * The store method is responsible for storing a new factoring in the database.
     * It first validates the input against a set of rules, if any of the validations fail,
     * it redirects back to the create view with the input and errors.
     * If the validation succeeds, it saves the factoring to the database, and redirects
     * to the edit view with a message of success.
     * @return ResponseInterface the rendered view
     */
    public function store()
    {   

        $validation = service('validation');
        $rules = [
            'seller_id'     => 'required',
            'buyer_id'        => 'required',
            'invoice_external_reference_id' => 'required|min_length[10]|max_length[255]|is_unique[factorings.invoice_external_reference_id]',
            'language'                => 'required|max_length[2]',
            'payment_method'          => 'required|max_length[50]',
            'invoice_issued_at'       => 'required|valid_date',
            'total_discount_cents'    => 'required|numeric',
            'gross_amount_cents'      => 'required|numeric',
            'currency'          => 'required|max_length[3]',
            'net_term'          => 'required|numeric'
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

        $data['created_by'] = $this->session->user['id'];
        $model->save($data);
        return redirect()->to('/factoring/edit/'.$model->getInsertID())->with('message', 'Factoring has been created, add items and continue.');
    }

    /**
     * The edit method is responsible for rendering the edit view, which displays the form to update a factoring.
     * It first checks if the user is logged in, if not it redirects to the login page.
     * Then it sets up the data to be passed to the view, including the user's full name,
     * the active sidebar item, the page being viewed, the message to be displayed, and the errors to be displayed.
     * It also sets up the factoring, sellers, buyers, factoring items, buyer addresses, and buyer representatives to be displayed in the form.
     * Finally, it renders the view.
     * @param int $id the ID of the factoring to be edited
     * @return ResponseInterface the rendered view
     */
    public function edit($id)
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('login');
        }

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
        $data['buyer_address_billing'] = $buyer_address_model->where('buyer_id', $data['factoring']['buyer_id'])->where('type', 'billing')->where('status', 'Active')->findAll();
        $data['buyer_address_shipping'] = $buyer_address_model->where('buyer_id', $data['factoring']['buyer_id'])->where('type', 'shipping')->where('status', 'Active')->findAll();
        $data['buyer_representative'] = $buyer_representative_model->where('buyer_id', $data['factoring']['buyer_id'])->where('status', 'Active')->findAll();
        return  view('theme/head')
        .view('theme/sidebar', $data)
        .view('theme/header')
        .view('Factoring/edit', $data)
        .view('theme/footer');
    }

    /**
     * Update a factoring invoice.
     * 
     * This function validates the request input against the rules defined in $rules.
     * If the validation fails, it redirects the user to the edit view with the errors.
     * If the validation passes, it updates the factoring invoice and redirects the user
     * to the same view with a success message. If the API call fails, it redirects the
     * user to the same view with the errors.
     * @param int $id the ID of the factoring to be updated
     * @return ResponseInterface the rendered view
     */
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
        $data['gross_amount_cents'] = $this->request->getPost('gross_amount_cents');
        $data['total_discount_cents'] = $this->request->getPost('total_discount_cents');
        $data['net_term'] = $this->request->getPost('net_term');
        $data['invoice_url'] = $this->request->getPost('invoice_url');
        $data['updated_by'] = $this->session->user['id'];
        $model->update($id, $data);
        $factoring = $model->find($id);
        $factoringItem_model = new FactoringItemModel();
        $factoring_items = $factoringItem_model->where('factoring_id', $id)->findAll();
        // body parameters
        $body_param = [
            'invoice_external_reference_id' => $factoring['invoice_external_reference_id'],
            'currency' => $factoring['currency'],
            'net_term' => $factoring['net_term'],
            'payment_method' => $factoring['payment_method'],
            'total_discount_cents' => $factoring['total_discount_cents'] * 100,
            'invoice_issued_at' => $factoring['invoice_issued_at'],
            'gross_amount_cents' => $factoring['gross_amount_cents'] * 100,
            'language' => $factoring['language'],
            'invoice_url' => $factoring['invoice_url'],
        ];
        // $filePath = FCPATH.'uploads/Invoice_2023102501.pdf';//fopen($filePath, 'r');
        // $body_param['file'] = $filePath;
        // Get buyer details
        $buyer_details = $buyer_model->where('id', $factoring['buyer_id'])->first();
        // lines parameters
        $lines = [];
        $i = 0;
        foreach($factoring_items as $factoring_item):

            $lines['lines'][$i] = $data['lines'][$i] = [
                'line_items' => [[
                    'quantity' => $factoring_item['quantity'],
                    'external_reference_id' => $factoring_item['external_reference_id'],
                    'title' => $factoring_item['title'],
                    'net_price_per_item_cents' => $factoring_item['net_price_per_item_cents'] * 100,
                    'tax_cents' => $factoring_item['item_tax_cents'] * 100,
                ]],
                'net_price_cents' => $factoring_item['net_price_per_item_cents'] * 100,
                'discount_cents' => $factoring_item['discount_cents'] * 100,
                'shipping_price_cents' => $factoring_item['shipping_price_cents'] * 100,
            ];
            $i++;

        endforeach;
        
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
        // Log the request parameters for debugging purposes
        log_message('info', 'Request Parameters: ' . json_encode($final_parameters, JSON_PRETTY_PRINT));

        $seller_model = new SellerModel();
        $seller_details = $seller_model->where('id', $factoring['seller_id'])->first();
        $send = $this->sendPost($seller_details['api_key'], json_encode($final_parameters));
        // Log the API response for debugging purposes
        log_message('info', 'API Response: ' . json_encode($send, JSON_PRETTY_PRINT));

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

    /**
     * Get the list of all factorings in JSON format
     *
     * @return JSON
     */
        public function lists()
    {
        $model = new FactoringModel();
        $factorings = $model->select('factorings.id, invoice_external_reference_id as external_reference_id, sellers.name seller_name, buyers.name buyer_name, gross_amount_cents gross_amount, currency, net_term, factorings.status, factorings.created_at')
                        ->join('sellers', 'sellers.id = factorings.seller_id')
                        ->join('buyers', 'buyers.id = factorings.buyer_id')
                        ->findAll();
        $TotalRecords = $model->countAllResults();
        $data['recordsFiltered'] = $TotalRecords;
        $data['data'] = [];
        $x = 0;
        foreach($factorings as $key => $value):

            $data['data'][$key] = $value;
        $x++;
        endforeach;
        echo json_encode($data);
    }

    /**
     * Get the upload form for a factoring invoice
     * @param int $id the ID of the factoring invoice
     * @return view the upload form view
     */
    public function upload($id)
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('login');
        }
        $factoring_model = new FactoringModel();
        $data['factoring'] = $factoring_model->where('id', $id)->first();
        $data['views_page'] = $this->session->views_page;
        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
        $data['message'] = $this->session->message;
        $data['errors'] = $this->session->errors;
        return  view('theme/head')
        .view('theme/sidebar', $data)
        .view('theme/header')
        .view('Factoring/upload', $data)
        .view('theme/footer');
    }

    /**
     * Convert a given date time string to a Carbon DateTime string
     *
     * @param string $from_data the date time string to convert
     * @return string the converted date time string
     */
    private function toDateTimeString($from_data)
    {
        $time = Time::parse($from_data);
        return $time->toDateTimeString();
    }

    /**
     * Sends a POST request to the Mondu API with the given API key and request body.
     *
     * @param string $api_key the API key to use for the request
     * @param string $body the request body to send
     *
     * @return array an array containing the status code and response body
     *
     * @throws \GuzzleHttp\Exception\RequestException if the request fails
     */
    private function sendPost($api_key, $body)
    {
        $client = new Client();
        try {
            $response = $client->request('POST', getenv('MONDU_ENDPOINT') . '/factorings', [
                'headers' => [
                    'Api-Token' => $api_key,
                    'Accept'    => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'body' => $body,
            ]);

            $statusCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody()->getContents());

            if (!in_array($statusCode, [200, 201, 202])) {
                return [
                    'status_code' => $statusCode,
                    'data'        => $responseBody->errors ?? $responseBody,
                ];
            }

            return [
                'status_code' => $statusCode,
                'data'        => $responseBody,
            ];
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $response = $e->getResponse();
            $statusCode = $response ? $response->getStatusCode() : $e->getCode();
            $responseBody = $response ? json_decode($response->getBody()->getContents()) : ['message' => $e->getMessage()];

            return [
                'status_code' => $statusCode,
                'data'        => $responseBody->errors ?? $responseBody,
            ];
        }
    }
}