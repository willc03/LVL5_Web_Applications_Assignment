<?php
namespace App\Controllers;

class Golf extends BaseController
{
    public function index()
    {
        $isLoggedIn = session()->get('isLoggedIn');
        // Redirect the user if they are not logged in as a member or visitor
        if (!$isLoggedIn)
        {
            return redirect()->to(site_url('/home?error=not_logged_in'));
        }
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

    /**
     * This controller function will be used to deliver the page and necessary
     * security for creating new bookings.
     *
     * @return void
     */
    public function newBooking($requestType): string
    {
        if ($requestType == "POST") // If the booking request is made
        {

        }
        else // If the page's HTML is being requested
        {
            $data["title"] = "Create Booking";
            $data["nav_pages"] = $this->getNavigationBarPages();
            return view('templates/memberTemplates/header', $data)
                 . view('pages/golf/booking_create')
                 . view('templates/memberTemplates/footer');
        }
    }
}