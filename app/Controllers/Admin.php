<?php
namespace App\Controllers;

class Admin extends BaseController
{
    public function index($page = 'portal')
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
        $titles = array('portal' => 'Admin Portal', 'manage_golf' => 'Manage Golf', 'manage_user' => 'Manage Users');
        $data['title'] = $titles[$page];
        $data['nav_pages'] = $this->getNavigationBarPages();
        // View pages
        return view('templates/memberTemplates/header', $data)
             . view('pages/admin/' . $page)
             . view('templates/memberTemplates/footer');
    }

    public function private($page)
    {
        $isLoggedIn = session()->get('isLoggedIn');
        // Redirect the user if they are not logged in as a member or visitor
        if (!$isLoggedIn)
        {
            return redirect()->to(site_url('/home?error=not_logged_in'));
        }
        elseif (session()->get('privilegeLevel') < 5)
        {
            return redirect()->to(site_url('/admin?error=no_access'));
        }
        // Set up data
        $data['title'] = $page == 'manage_bar' ? "Manage Bar" : ucfirst($page);

        $data['nav_pages'] = $this->getNavigationBarPages();
        // View pages
        return view('templates/memberTemplates/header', $data)
            . view('pages/admin/' . $page)
            . view('templates/memberTemplates/footer');
    }
}