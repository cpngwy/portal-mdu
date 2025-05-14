<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\Factoring;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    /**
     * Handles the rendering of the dashboard index page.
     * 
     * This function ensures that the user is authenticated before proceeding.
     * It collects various data points including the user's full name, active sidebar,
     * gross amount monthly, and status percentages (approved, declined, pending, processing).
     * The data is passed to the views for rendering the dashboard interface.
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface Redirect to login if not authenticated 
     * or the combined view of the dashboard.
     */

    public function index()
    {
        // Ensure user is authenticated
        if (!auth()->loggedIn()) {
            return redirect()->to('login');
        }

        $data['user_full_name'] = $this->session->user_full_name;
        $data['active_sidebar'] = $this->session->active_sidebar;
        $data['get_gross_amount_monthly'] = $this->get_gross_amount_monthly();
        $data['approved_percent'] = (double)$this->get_percentage('approved');
        $data['declined_percent'] = (double)$this->get_percentage('declined');
        $data['pending_percent'] = (double)$this->get_percentage('pending');
        $data['processing_percent'] = (double)$this->get_percentage('processing');

        $data['views_page'] = 'index';
        return  view('theme/head')
                .view('theme/sidebar', $data)
                .view('theme/header')
                .view('Dashboard/index', $data)
                .view('theme/footer');
    }

    /**
     * Provides the gross amount monthly for the current year.
     * 
     * The results are returned as a JSON encoded array.
     * 
     * @return string json encoded array
     */
    public function gross_amount_monthly()
    {
        for($x=1; $x<=12; $x++)
        {
            $y = $x-1;
            $amount[$y] = $this->sum_transaction($this->session->user['seller_id'], date('Y').'-0'.$x.'-01', date('Y').'-0'.$x.'-31 23:59:59', 'factoring', 'approved');
        }
        return json_encode($amount);
    }

    /**
     * Provides the percentage of the total records for each status.
     * 
     * The results are returned as a JSON encoded array.
     * 
     * @return string json encoded array
     */

    public function status_percentage()
    {
        $percentage[0] = $this->get_percentage('pending');
        $percentage[1] = $this->get_percentage('processing');
        $percentage[2] = $this->get_percentage('confirmed');
        $percentage[3] = $this->get_percentage('approved');
        $percentage[4] = $this->get_percentage('declined');
        return json_encode($percentage);
    }

    /**
     * Retrieves the gross amount for each month of the current year.
     * 
     * This function utilizes the Factoring model to fetch and return
     * the gross amount monthly for the current user based on their
     * seller ID.
     * 
     * @return array The gross amount for each month.
     */

    private function get_gross_amount_monthly()
    {
        $factoring = new Factoring();
        return $factoring->get_gross_amount_monthly($this->session->user['seller_id']);
    }

    /**
     * Calculates the percentage of records for a given status type.
     * 
     * This function utilizes the Factoring model to determine the percentage
     * of records that match the specified status type ('approved', 'declined', etc.)
     * for the current user based on their seller ID. It retrieves the total number 
     * of records and computes the percentage for the given status type.
     * 
     * @param string $type The status type for which the percentage is calculated.
     * @return float The formatted percentage of records with the given status type,
     *               or 0.00 if the percentage could not be computed.
     */

    private function get_percentage($type)
    {
        $factoring = new Factoring();
        $total_records = $factoring->select('COUNT(status) as total')->where('seller_id', $this->session->user['seller_id'])->groupBy('seller_id')->first();
        $percentage = $factoring->get_percentage($this->session->user['seller_id'], $type, $total_records['total'] ?? 0);
        return number_format($percentage, 3);
    }

    /**
     * Sums the gross amount for a given time period and status type.
     * 
     * This function utilizes the Factoring model to sum the gross amount
     * of records for a given time period and status type ('approved', 'declined', etc.)
     * for the current user based on their seller ID.
     * 
     * @param int $seller_id The ID of the seller for which the records are retrieved.
     * @param string $start The start date for the time period in the format 'Y-m-d'.
     * @param string $end The end date for the time period in the format 'Y-m-d'.
     * @param string $type The type of records to be retrieved ('factoring', 'bank_transfer', etc.).
     * @param string $status The status type of records to be retrieved, or empty if all records are desired.
     * @return float The sum of the gross amounts for the given time period and status type.
     */
    private function sum_transaction($seller_id, $start, $end, $type, $status)
    {
        $factoring = new Factoring();
        
        if(empty($status)):
        
            $query = $factoring->select('SUM(gross_amount_cents) as gross_amount_cents')
            ->where(plural($type).'.seller_id', $seller_id)
            ->where(plural($type).'.created_at >=', $start)
            ->where(plural($type).'.created_at <=', $end)->first();
            return $query['gross_amount_cents'] ?? 0.00;

        endif;

        $query = $factoring->select('SUM(gross_amount_cents) as gross_amount_cents')
        ->where(plural($type).'.seller_id', $seller_id)
        ->where(plural($type).'.status', $status)
        ->where(plural($type).'.created_at >=', $start)
        ->where(plural($type).'.created_at <=', $end)->first();
        return $query['gross_amount_cents'] ?? 0.00;
    }
}