<?php

namespace App\Controllers;

class Members extends BaseController
{
    public function index()
    {

        $isLoggedIn = session()->get('isLoggedIn');
        // Redirect the user if they are not logged in as a member or visitor
        if (!$isLoggedIn)
        {
            return redirect()->to(site_url('/home?error=not_logged_in'));
        }
        elseif (session()->get('privilegeLevel') < 2)
        {
            return redirect()->to(site_url('/home?error=access_denied'));
        }
        // Set up the navigation pages, title, and return the views.
        $data['nav_pages'] = $this->getNavigationBarPages();
        $data['title'] = 'Members Portal';
        return view('templates/memberTemplates/header', $data)
            . view('pages/dynamic/memberPages/portalHome')
            . view('templates/memberTemplates/footer');
    }
}
