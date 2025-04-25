<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Models\UserModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];
    /**
     * Secure Pages with Role-Based Access
     *
     * @return boolean
     */  
    protected function isAdmin()
    {
        $user = auth()->user();
        return $user && $user->inGroup('admin');
    }

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        
        // Preload any models, libraries, etc, here.
        helper('form');
        helper('auth');
        helper('setting');
        helper('text');

        // load services
        $this->request = \Config\Services::request();
        $this->session = \Config\Services::session();
        $this->uri = \Config\Services::uri();

        // get Segment 2 for sidebar menu
        $segment = (empty($this->uri->getSegment(1))) ? 'dashboard' : $this->uri->getSegment(1);
        // die($segment);
        $this->session->set('active_sidebar', $segment);
        // var_dump($this->session);
    }
}