<?php
namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {

        // Set up data
        $data['title'] = 'Admin';

        $data['nav_pages'] = $this->getNavigationBarPages();
        // View pages
        return view('templates/memberTemplates/header', $data)
             . view('templates/memberTemplates/footer');
    }
}