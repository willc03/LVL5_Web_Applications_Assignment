<?php

namespace App\Controllers;

class Members extends BaseController
{
    public function index()
    {

        $isLoggedIn = $this->session->get('isLoggedIn');
        if (!$isLoggedIn)
        {
            return redirect()->to(site_url('/home?error=not_logged_in'));
        }

        $data['nav_pages'] = $this->getNavigationBarPages();
        $data['title'] = 'Members Portal';
        return view('templates/memberTemplates/header', $data)
            .view('pages/dynamic/memberPages/portalHome')
            . view('templates/memberTemplates/footer');
    }

    public function test()
    {
        echo 'test';
    }
}
