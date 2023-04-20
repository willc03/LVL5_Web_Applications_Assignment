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
     * @return any (returns pages to be viewed)
     */
    public function index()
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

    /*
     * This controller function will be used to deliver the page and necessary
     * security for creating new bookings.
     *
     * @return any
     */
    public function newBooking($requestType)
    {
        if ($requestType == "POST") // If the booking request is made
        {

        }
        else // If the page's HTML is being requested
        {
            // Validation to ensure the necessary items are stored
            if (!isset($_GET['time']) || !isset($_GET['date']))
            {
                return redirect()->to(site_url('/golf?error=insufficient_data'));
            }
            else
            {
                $GolfManager = model("GolfManagement");
                if ( count($GolfManager->GetBookingAtTime(esc($_GET['date']), esc($_GET['time']))) > 0 )
                {
                    return redirect()->to(site_url('/golf?error=booking_conflict'));
                }
            }
            // Page data to be passed in
            $data["title"] = "Create Booking";
            $data["nav_pages"] = $this->getNavigationBarPages();
            return view('templates/memberTemplates/header', $data)
                 . view('pages/golf/booking_create')
                 . view('templates/memberTemplates/footer');
        }
    }

    public function booking()
    {
        $data['title'] = 'Edit Booking';
        $data['nav_pages'] = $this->getNavigationBarPages();
        return view('templates/memberTemplates/header', $data)
             . view('templates/memberTemplates/footer');
    }
}