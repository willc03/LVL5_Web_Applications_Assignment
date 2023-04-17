<?php

/*
    This controller will  be used for pages  which do not require any
    database C.R.U.D. operations. Pages such as these will be the ho-
    me  page,  the about page,  and other pages which may ne added in
    the future.
*/

// This script is taken from CodeIgniter for the initial commit.
// It will most likely be changed in future commits.

namespace App\Controllers;

class Golf extends BaseController
{
    public function index()
    {
        // Choose page
        $page_to_view = 'visitorGolf';
        if ( session()->get("privilegeLevel") >= 2 )
        {
            $page_to_view = 'memberGolf';
        }
        // Set up data
        $data['title'] = 'Golf';

        $data['nav_pages'] = $this->getNavigationBarPages();
        // View pages
        return view('templates/memberTemplates/header', $data)
             . view('pages/dynamic/memberPages/' . $page_to_view)
             . view('templates/memberTemplates/footer');
    }
}