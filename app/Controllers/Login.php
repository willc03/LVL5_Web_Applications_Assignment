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
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page); // No page is available.
        }
        // Set the title of the page.
        $data['title'] = ucfirst($page);
        // Get the navigation pages.
        $data['nav_pages'] = $this->getNavigationBarPages();
        // Add the page content
        return view('templates/staticTemplates/header', $data)
            . view('pages/dynamic/loginPages/' . $page)
            . view('templates/staticTemplates/footer');
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
        $UserAuthModel = model('UserAuthentication');
        // Check the form can be processed
        if (!$this->ProcessSignUpRequestItems($_POST))
        {
            return redirect()->to(site_url('/account/create?error=form_incomplete'));
        }
        else
        {
            $userIsAdded = $UserAuthModel->AddNewUser(array(
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'firstname' => $_POST['fname'],
                'lastname' => $_POST['lname'],
                'address' => $_POST['ad1'] . ', ' . $_POST['ad2'] . ', ' . $_POST['town'] . ', ' . $_POST['county'] . ', ' . $_POST['pcode'],
                'dob' => $_POST['dob']
            ));
            if ($userIsAdded)
            {
                return redirect()->to(site_url('/account/login?message=signup_successful'));
            }
            else
            {
                return redirect()->to(site_url('/account/create?error=database_error'));
            }
        }
    }
    public function userLoginRequest()
    {
        // Code to authenticate users will go here before the redirection.
        $UserAuthModel = model('UserAuthentication');
        // Check if the user exists
        $UserAuthentication = $UserAuthModel->AuthenticateUser($_POST['email'], $_POST['password']);
        if ( $UserAuthentication == "Success" )
        {
            $this->session->set("isLoggedIn", true);
            $this->session->set("privilegeLevel", $UserAuthModel->GetUserPrivilege($_POST['email']));
            return redirect()->to(site_url('/members'));
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
        // Destroy the session.
        $this->session->destroy();
        // Redirect to the home page.
        return redirect()->to(site_url('/'));
    }
}