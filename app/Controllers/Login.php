<?php

/*
    This controller will  be used for pages for login pages and oper-
    ations with the database and forms, such as adding users or vali-
    dating forms.
*/

namespace App\Controllers;

class Login extends BaseController
{

    // GET Request Handling
    public function view($page = 'login')
    {
        if (! is_file(APPPATH . 'Views/pages/dynamic/loginPages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }

        /*
            The title of the page will be passed in to the page to be used in
            the title bar of the browser.
        */
        $data['title'] = ucfirst($page);

        /*
            As CodeIgniter provides different functionality to  add different
            views dynamically  in the same page.  At the time of writing, the
            views added to the page will be a global header, followed by  the
            page content, and then a global footer. 
        */
        $data['nav_pages'] = $this->getNavigationBarPages();
        return view('templates/header', $data)
            . view('pages/dynamic/loginPages/' . $page)
            . view('templates/footer');
    }

    // POST Request Handling
    public function userSignUpRequest()
    {
        return redirect()->to(site_url('/login'));
    }

    public function userLoginRequest()
    {
        // Code to authenticate users will go here before the redirection.
        return redirect()->to(site_url('/'));
    }

    public function logout()
    {
        $this->session->destroy(); // Remove all session data. The user is n-
                                   // ow logged out.
        return redirect()->to(site_url('/'));
    }
}