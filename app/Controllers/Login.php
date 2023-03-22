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

    /*
     * POST Request Handling
     *
     * Private functions will be created to complete tasks that aren't accessed
     * via routing. Public functions will then handle tasks such as signing up
     * and logging in.
     */

    /**
     * This private function is used to process items from the Sign-Up form.
     * The main purpose of the function is to make sure no fields are empty.
     *
     * @param $postItems
     * @return void
     */
    private function ProcessSignUpRequestItems($postItems)
    {
        foreach ($postItems as $item)
        {
            if (strlen($item) <= 0)
            {
                return false;
            }
        }
        return true;
    }
    public function userSignUpRequest()
    {
        return redirect()->to(site_url('/login'));
    }
    public function userLoginRequest()
    {
        // Code to authenticate users will go here before the redirection.
        $UserAuthModel = model('UserAuthentication');
        // Check if the user exists
        $UserAuthentication = $UserAuthModel->AuthenticateUser($_POST['email'], $_POST['password']);
        if ( $UserAuthentication == "Success" )
        {
            return redirect()->to(site_url('/home'));
        }
        else
        {
            if ($UserAuthentication == "IncorrectPwd")
            {
                return redirect()->to(site_url('/account/login?error=incorrect_password'));
            }
            elseif ($UserAuthentication == "NoUser")
            {
                return redirect()->to(site_url('/account/login?error=unknown_user'));
            }
        }
    }

    public function logout()
    {
        $this->session->destroy(); // Remove all session data. The user is n-
                                   // ow logged out.
        return redirect()->to(site_url('/'));
    }
}