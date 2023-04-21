<?php
namespace App\Controllers;

class API extends BaseController
{
    public function memberGet()
    {
        $isLoggedIn = session()->get('isLoggedIn');
        // Redirect the user if they are not logged in as a member or visitor
        if (!$isLoggedIn)
        {
            return redirect()->to(site_url('/home?error=not_logged_in'));
        }
        //
        $APIModel = model("API");
        return json_encode($APIModel->GetMembers());
    }
}