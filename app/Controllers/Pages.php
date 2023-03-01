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

class Pages extends BaseController
{
    public function view($page = 'home')
    {
        if (! is_file(APPPATH . 'Views/pages/static/' . $page . '.php')) {
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
            . view('pages/static/' . $page)
            . view('templates/footer');
    }
}