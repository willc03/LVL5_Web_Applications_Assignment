<?php
namespace App\Controllers;

class Golf extends BaseController
{
    /**
     * This controller function will be used to display the contents of the core
     * golf page, which will  have an overview of the tee time sheet and buttons
     * which will redirect the user to create a new booking or edit their exist-
     * ing bookings.
     * 
     * @return string (returns pages to be viewed)
     */
    public function index(): string
    {
        // Security check to disallow users to access the page if they are not logged in
        if (!session()->has('isLoggedIn'))
        {
            return redirect()->to(site_url('/home?error=not_logged_in'));
        }
        // Set whether to return the page for visitors golf or members golf
        $page_to_view = 'visitors_golf';
        if ( session()->get("privilegeLevel") >= 2 ) // Change the view to the member golf page if they are a member (2 or higher privilege)
        {
            $page_to_view = 'members_golf';
        }
        // Get the navigation pages and page title
        $data['title'] = 'Golf';
        $data['nav_pages'] = $this->getNavigationBarPages();
        // View pages
        return view('templates/memberTemplates/header', $data)
             . view('pages/golf/' . $page_to_view)
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