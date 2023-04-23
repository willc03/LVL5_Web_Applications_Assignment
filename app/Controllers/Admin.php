<?php
namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {
        $isLoggedIn = session()->get('isLoggedIn');
        // Redirect the user if they are not logged in as a member or visitor
        if (!$isLoggedIn)
        {
            return redirect()->to(site_url('/home?error=not_logged_in'));
        }
        elseif (session()->get('privilegeLevel') < 5)
        {
            return redirect()->to(site_url('/home?error=access_denied'));
        }
        // Set up data
        $data['title'] = 'Admin';

        $data['nav_pages'] = $this->getNavigationBarPages();
        // View pages
        return view('templates/memberTemplates/header', $data)
             . view('pages/admin/portal')
             . view('templates/memberTemplates/footer');
    }
}