<?php
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