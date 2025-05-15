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
use GuzzleHttp\Psr7\Utils;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use CodeIgniter\Files\File;

class Factoring extends BaseController
{
    /**
     * The index method is responsible for rendering the index view, which displays the list of
     * all factoring. It first checks if the user is logged in, if not it redirects to the login page.
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

        $data['user_group'] = $this->session->user_group ?? 'user';
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
        $data['user_group'] = $this->session->user_group ?? 'user';
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
        $data['user_group'] = $this->session->user_group ?? 'user';
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

        // Get the status of the factoring from the API and update the factoring status in the database if it has been approved.
        // This is done to ensure that the factoring status in the database is up to date.
        if($data['factoring']['status'] !== 'approved' && !(empty($data['factoring']['factoring_uuid']))):
            $seller_details = $seller_model->find($data['factoring']['seller_id']);
            $get_factoring_details = $this->get_factoring_details($data['factoring']['factoring_uuid'], $seller_details['api_key']);
            if($get_factoring_details['status_code'] === 200):
                $get_factoring_details = [
                    'status' => $get_factoring_details['data']->factoring->state,
                ];
                $model->update($id, $get_factoring_details);
                $data['factoring'] = $model->find($id);
                return redirect()->to('/factoring/edit/'.$id)
                ->with('response', $get_factoring_details)
                ->with('message', ucfirst($data['factoring']['status']));
            endif;
        endif;

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
        // $validation = service('validation');
        // $rules = [
        //     'invoice_issued_at' => 'required|valid_date',
        // ];
        // $data = $this->request->getPost(array_keys($rules));
        // if (! $this->validateData($data, $rules)) {
        //     return redirect()->to('/factoring/edit/'.$id)
        //             ->with('errors', $this->validator->getErrors());
        // }

        $model = new FactoringModel();
        $buyer_model = new BuyerModel();
        $buyer_address_model = new BuyerAddressModel();
        $buyer_representative_model = new BuyerRepresentativeModel();
        $data = $this->request->getPost();
        $factoring = $model->find($id);
        $factoringItem_model = new FactoringItemModel();
        $factoring_items = $factoringItem_model->where('factoring_id', $id)->findAll();
        $data['owner_is_authorized'] = $this->request->getPost('owner_is_authorized') === 'on' ? 1 : 0;
        $data['gross_amount_cents'] = $this->request->getPost('gross_amount_cents');
        $data['total_discount_cents'] = $this->request->getPost('total_discount_cents');
        $data['net_term'] = $this->request->getPost('net_term');
        $data['updated_by'] = $this->session->user['id'];
        $model->update($id, $data);
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
            'invoice_url' => base_url('/factoring/link/'.$factoring['invoice_external_reference_id'].'.pdf'),
        ];
        // $filePath = FCPATH.'uploads/Invoice_2023102501.pdf';//fopen($filePath, 'r');
        // $body_param['file'] = $this->request->getFile('file');
        // Get buyer details
        $buyer_details = $buyer_model->where('id', $factoring['buyer_id'])->first();
        // lines parameters
        $lines = [];
        $i = 0;
        foreach($factoring_items as $factoring_item):

            $lines['lines'][$i] = [
                'line_items' => [[
                    'quantity' => $factoring_item['quantity'],
                    'external_reference_id' => $factoring_item['external_reference_id'],
                    'title' => $factoring_item['title'],
                    'net_price_per_item_cents' => $factoring_item['net_price_per_item_cents'] * 100,
                    'tax_cents' => $factoring_item['item_tax_cents'] * 100,
                    'net_price_cents' => ($factoring_item['net_price_per_item_cents'] * 100) * $factoring_item['quantity'],
                ]],
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
                if($key == 'name'):
                    $buyer['buyer']['company_name'] = $value;
                else:
                    $buyer['buyer'][($key == 'buyer_code') ? 'external_reference_id' : $key] = $value;
                endif;
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

        $seller_model = new SellerModel();
        $seller_details = $seller_model->where('id', $factoring['seller_id'])->first();
        // $send = $this->sendPost($seller_details['api_key'], json_encode($final_parameters));
        echo "<pre/>";
        $send = $this->sendPost($seller_details['api_key'], $final_parameters);
        // $send = $this->sendRequest($seller_details['api_key'], $final_parameters);
        $status_code = [200, 201, 202];
        if(in_array($send['status_code'], $status_code)):
            $factoring_uuid = $send['data']->factoring_uuid;
            $status = $send['data']->state;
            $this->update_factoring_uuid($id, $factoring_uuid, $status);
            return redirect()->to('/factoring/edit/'.$id)
            ->with('parameters', json_encode($final_parameters))
            ->with('response', $send)
            ->with('message', ucfirst($send['data']->state));
        endif;
        
        return redirect()->to('/factoring/edit/'.$id)
        ->with('parameters', json_encode($final_parameters))
        ->with('response',  $send['data'])
        ->with('errors',  $send['data']);
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
                        ->orderBy('created_at', 'DESC')
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
        $data['user_group'] = $this->session->user_group ?? 'user';
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
     * Given an invoice external reference ID, returns the contents of the
     * corresponding invoice PDF file, with HTTP headers set to force the
     * browser to render the PDF inline.
     *
     * @param string $invoice_external_reference_id the external reference ID
     * of the invoice
     * @return mixed the response object
     */
    public function file_link($invoice_external_reference_id)
    {
        helper("filesystem");
        $path = WRITEPATH . 'uploads/Mondu_Factoring_Invoices/';
        $filename = $invoice_external_reference_id;
        $fullpath = $path . $filename;
        $file = new \CodeIgniter\Files\File($fullpath, true);
        $binary = readfile($fullpath);
        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->setBody($binary);
    }
    /**
     * Updates the factoring uuid and status for the given factoring ID
     * @param int $id the ID of the factoring invoice
     * @param string $factoring_uuid the new factoring uuid to update
     * @param string $status the new status to update
     * @return void
     */
    private function update_factoring_uuid($id, $factoring_uuid, $status)
    {
        $model = new FactoringModel();
        $update_data = ['factoring_uuid' => $factoring_uuid, 'status' => $status];
        $model->update($id, $update_data);
        redirect()->to('/factoring/edit/'.$id)->with('message', 'Factoring status updated to '.$status);
    }

    private function update_factoring_status($id, $status)
    {
        $model = new FactoringModel();
        $update_data = ['status' => $status];
        $model->update($id, $update_data);
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
     * Sends a POST request to the Mondu API to create a new factoring with the attached PDF invoice.
     *
     * @return string the response body of the API call
     */
    private function sendRequest($api_key, $body)
    {
        try {
            $client = new Client();
            $utils = new Utils();
            $filePath = WRITEPATH . 'uploads/Mondu_Factoring_Invoices/' . $body['invoice_external_reference_id'] . '.pdf';

            if (!file_exists($filePath)) {
                return 'Invoice PDF file not found.';
            }

            $multipart = [
                ['name' => 'invoice_external_reference_id', 'contents' => $body['invoice_external_reference_id']],
                ['name' => 'currency', 'contents' => $body['currency']],
                ['name' => 'net_term', 'contents' => $body['net_term']],
                ['name' => 'payment_method', 'contents' => $body['payment_method']],
                ['name' => 'total_discount_cents', 'contents' => $body['total_discount_cents']],
                ['name' => 'invoice_issued_at', 'contents' => $body['invoice_issued_at']],
                ['name' => 'gross_amount_cents', 'contents' => $body['gross_amount_cents']],
                ['name' => 'language', 'contents' => $body['language']],
                
                ['name' => 'lines[0][line_items][0][quantity]', 'contents'                  => $body['lines'][0]['line_items'][0]['quantity']],
                ['name' => 'lines[0][line_items][0][external_reference_id]', 'contents'     => $body['lines'][0]['line_items'][0]['external_reference_id']],
                ['name' => 'lines[0][line_items][0][title]', 'contents'                     => $body['lines'][0]['line_items'][0]['title']],
                ['name' => 'lines[0][line_items][0][net_price_per_item_cents]', 'contents'  => $body['lines'][0]['line_items'][0]['net_price_per_item_cents']],
                ['name' => 'lines[0][line_items][0][tax_cents]', 'contents'                 => $body['lines'][0]['line_items'][0]['tax_cents']],
                ['name' => 'lines[0][line_items][0][net_price_cents]', 'contents'           => $body['lines'][0]['line_items'][0]['net_price_cents']],
                ['name' => 'lines[0][discount_cents]', 'contents'                           => $body['lines'][0]['discount_cents']],
                ['name' => 'lines[0][shipping_price_cents]', 'contents'                     => $body['lines'][0]['shipping_price_cents']],

                ['name' => 'buyer[external_reference_id]', 'contents' => $body['buyer']['external_reference_id']],
                ['name' => 'buyer[company_name]', 'contents' => $body['buyer']['company_name']],
                ['name' => 'buyer[registration_id]', 'contents' => $body['buyer']['registration_id']],
                ['name' => 'buyer[first_name]', 'contents' => $body['buyer']['first_name']],
                ['name' => 'buyer[last_name]', 'contents' => $body['buyer']['last_name']],
                ['name' => 'buyer[email]', 'contents' => $body['buyer']['email']],

                ['name' => 'billing_address[country_code]', 'contents' => $body['billing_address']['country_code']],
                ['name' => 'billing_address[state]', 'contents' => $body['billing_address']['state']],
                ['name' => 'billing_address[city]', 'contents' => $body['billing_address']['city']],
                ['name' => 'billing_address[zip_code]', 'contents' => $body['billing_address']['zip_code']],
                ['name' => 'billing_address[address_line1]', 'contents' => $body['billing_address']['address_line1']],
                ['name' => 'billing_address[address_line2]', 'contents' => ''],

                ['name' => 'shipping_address[country_code]', 'contents' => $body['shipping_address']['country_code']],
                ['name' => 'shipping_address[state]', 'contents' => $body['shipping_address']['state']],
                ['name' => 'shipping_address[city]', 'contents' => $body['shipping_address']['city']],
                ['name' => 'shipping_address[zip_code]', 'contents' => $body['shipping_address']['zip_code']],
                ['name' => 'shipping_address[address_line1]', 'contents' => $body['shipping_address']['address_line1']],

                ['name' => 'owners[0][is_authorized]', 'contents' => 'true'],
                ['name' => 'owners[0][first_name]', 'contents' => $body['buyer']['first_name']],
                ['name' => 'owners[0][last_name]', 'contents' => $body['buyer']['last_name']],
                [
                    'name'     => 'file',
                    'contents' => $utils->tryFopen($filePath, 'r'),
                    'filename' => $body['invoice_external_reference_id'] . '.pdf'
                ],
            ];
            log_message('info', 'Multipart-header: ' . print_r($multipart, true));
            $response = $client->request('POST', getenv('MONDU_ENDPOINT') . '/factorings', [
                'headers' => [
                    'Api-Token' => $api_key,
                ],
                // 'multipart' => [$multipart],
                // this is just a temporary fix and I will make it optimized and clean code
                'multipart' => $multipart
            ]);
            $statusCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody()->getContents());
            if (!in_array($statusCode, [200, 201, 202])) {
                // Log the API response for debugging purposes
                log_message('info', 'API Response: ' . json_encode([
                    'status_code' => $statusCode,
                    'data'        => $responseBody->errors ?? $responseBody,
                ], JSON_PRETTY_PRINT));

                return [
                    'status_code' => $statusCode,
                    'data'        => $responseBody->errors ?? $responseBody,
                ];
                
            }

            // Log the API response for debugging purposes
            log_message('info', 'API Response: ' . json_encode([
                'status_code' => $statusCode,
                'data'        => $responseBody,
            ], JSON_PRETTY_PRINT));

            return [
                'status_code' => $statusCode,
                'data'        => $responseBody,
            ];
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $response = $e->getResponse();
            $statusCode = $response ? $response->getStatusCode() : $e->getCode();
            $responseBody = $response ? json_decode($response->getBody()->getContents()) : ['message' => $e->getMessage()];
            // Log the API response for debugging purposes
            log_message('info', 'API Response: ' . json_encode([
                'status_code' => $statusCode,
                'data'        => $responseBody->errors ?? $responseBody,
            ], JSON_PRETTY_PRINT));

            return [
                'status_code' => $statusCode,
                'data'        => $responseBody->errors ?? $responseBody,
            ];
            
        }
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
            $multipart = $this->flattenArray($body);
           
            log_message('info', 'Request Parameters: ' . print_r($multipart, true));
            // die(var_dump($multipart));
            $response = $client->request('POST', getenv('MONDU_ENDPOINT') . '/factorings', [
                'headers' => [
                    'Api-Token' => $api_key,
                ],
                'multipart' => $multipart,
            ]);
            
            $statusCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody()->getContents());

            if (!in_array($statusCode, [200, 201, 202])) {
                // Log the API response for debugging purposes
                log_message('info', 'API Response: ' . json_encode([
                    'status_code' => $statusCode,
                    'data'        => $responseBody->errors ?? $responseBody,
                ], JSON_PRETTY_PRINT));

                return [
                    'status_code' => $statusCode,
                    'data'        => $responseBody->errors ?? $responseBody,
                ];
                
            }

            // Log the API response for debugging purposes
            log_message('info', 'API Response: ' . json_encode([
                'status_code' => $statusCode,
                'data'        => $responseBody,
            ], JSON_PRETTY_PRINT));

            return [
                'status_code' => $statusCode,
                'data'        => $responseBody,
            ];
            
            
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $response = $e->getResponse();
            $statusCode = $response ? $response->getStatusCode() : $e->getCode();
            $responseBody = $response ? json_decode($response->getBody()->getContents()) : ['message' => $e->getMessage()];
            // Log the API response for debugging purposes
            log_message('info', 'API Response: ' . json_encode([
                'status_code' => $statusCode,
                'data'        => $responseBody->errors ?? $responseBody,
            ], JSON_PRETTY_PRINT));

            return [
                'status_code' => $statusCode,
                'data'        => $responseBody->errors ?? $responseBody,
            ];
            
        }
    }

    private function get_factoring_details($uuid, $api_key) {
        $client = new Client();
        try {
            $response = $client->request('GET', getenv('MONDU_ENDPOINT') . "/factorings/$uuid", [
                'headers' => [
                    'Api-Token' => $api_key,
                    'accept' => 'application/json',
                ],
            ]);
            $statusCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody()->getContents());
            if (!in_array($statusCode, [200, 201, 202])) {
                // Log the API response for debugging purposes
                log_message('info', 'API Response: ' . json_encode([
                    'status_code' => $statusCode,
                    'data'        => $responseBody->factoring ?? $responseBody,
                ], JSON_PRETTY_PRINT));

                return [
                    'status_code' => $statusCode,
                    'data'        => $responseBody->factoring ?? $responseBody,
                ];
                
            }

            // Log the API response for debugging purposes
            log_message('info', 'API Response: ' . json_encode([
                'status_code' => $statusCode,
                'data'        => $responseBody->errors[0]->details ?? $responseBody,
            ], JSON_PRETTY_PRINT));

            return [
                'status_code' => $statusCode,
                'data'        => $responseBody->errors[0]->details ?? $responseBody,
            ];
            
            
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $response = $e->getResponse();
            $statusCode = $response ? $response->getStatusCode() : $e->getCode();
            $responseBody = $response ? json_decode($response->getBody()->getContents()) : ['message' => $e->getMessage()];
            // Log the API response for debugging purposes
            log_message('info', 'API Response: ' . json_encode([
                'status_code' => $statusCode,
                'data'        => $responseBody->errors[0]->details ?? $responseBody,
            ], JSON_PRETTY_PRINT));

            return [
                'status_code' => $statusCode,
                'data'        => $responseBody->errors[0]->details ?? $responseBody,
            ];
            
        }
    }

    /**
     * Flattens a multidimensional array into a single level array suitable for multipart form data.
     * Each element in the resulting array contains a 'name' key representing the path to the original element
     * in the input array and a 'contents' key representing the value of the element.
     * 
     * @param array $array The multidimensional array to flatten.
     * @param string $prefix The prefix for array keys, used for recursive calls.
     * 
     * @return array A flattened array where each element is an associative array with 'name' and 'contents' keys.
     */
    private function flattenArray($array, $prefix = '') {
        $result = [];
        foreach ($array as $key => $value) {
            $name = $prefix === '' ? $key : "{$prefix}[{$key}]";
            if (is_array($value)) {
                $result = array_merge($result, $this->flattenArray($value, $name));
            } else {
                $result[] = [
                    'name' => $name,
                    'contents' => $value
                ];
            }
        }
        return $result;
    }
    
    
}