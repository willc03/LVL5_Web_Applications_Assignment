<?php

// This script is taken from CodeIgniter for the initial commit.
// It will most likely be changed in future commits.

namespace App\Controllers;

class Pages extends BaseController
{
    public function view($page = 'home')
    {
        if (! is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }

        /*
            The navigation pages must be specified here, as they will need to
            appear  on every page of  the website. The array will be fed into
            the page when it is being generated to generate the buttons dyna-
            mically.
        */
        $data['nav_pages'] = array(
            array('url' => site_url('/home'), 'btn_title' => "Home"),
            array('url' => site_url('/about'), 'btn_title' => "About"),
            array('url' => site_url('/book'), 'btn_title' => "Bookings"),
        );

        return view('templates/header', $data)
            . view('pages/' . $page)
            . view('templates/footer');
    }
}