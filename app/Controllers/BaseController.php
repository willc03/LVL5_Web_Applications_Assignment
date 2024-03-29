<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

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
     * @var array
     */
    protected $helpers = [];

    /*
    Create a function to return all the pages to be placed on the navigation bar.

    This will allow the return of pages dynamically  based on a range of factors.
    At present, the idea is to return different buttons based on both login stat-
    us and user privilege level.
    */
    protected function getNavigationBarPages(): array
    {
        if ( session()->get('isLoggedIn') )
        {
            $privilegeLevel = session()->get("privilegeLevel");
            switch ($privilegeLevel)
            {
                default:
                    return array(
                        array('url' => site_url('/home'), 'btn_title' => "Home"),
                        array('url' => site_url('/about'), 'btn_title' => "About"),
                        array('url' => site_url('/golf'), 'btn_title' => "Book<br>Golf"),
                        array('url' => site_url('/account/logout'), 'btn_title' => "Logout")
                    );
                case 2:
                case 3:
                case 4:
                    return array(
                        array('url' => site_url('/home'), 'btn_title' => "Home"),
                        array('url' => site_url('/about'), 'btn_title' => "About"),
                        array('url' => site_url('/golf'), 'btn_title' => "Book<br>Golf"),
                        array('url' => site_url('/members/bar'), 'btn_title' => "Bar"),
                        array('url' => site_url('/members'), 'btn_title' => "Member<br>Portal"),
                        array('url' => site_url('/account/logout'), 'btn_title' => "Logout")
                    );
                case 5:
                case 6:
                    return array(
                        array('url' => site_url('/home'), 'btn_title' => "Home"),
                        array('url' => site_url('/about'), 'btn_title' => "About"),
                        array('url' => site_url('/golf'), 'btn_title' => "Book<br>Golf"),
                        array('url' => site_url('/members/bar'), 'btn_title' => "Bar"),
                        array('url' => site_url('/members'), 'btn_title' => "Member<br>Portal"),
                        array('url' => site_url('/admin'), 'btn_title' => "Admin<br>Panel"),
                        array('url' => site_url('/account/logout'), 'btn_title' => "Logout")
                    );
            }
        }
        else
        {
            return array(array('url' => site_url('/home'), 'btn_title' => "Home"), array('url' => site_url('/about'), 'btn_title' => "About"), array('url' => site_url('/account/login'), 'btn_title' => "Login"));
        }
    }

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger): void
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
    }
}
