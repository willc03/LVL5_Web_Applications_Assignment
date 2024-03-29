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
        // Get the navigation pages and page title
        $data['title'] = 'Golf';
        $data['nav_pages'] = $this->getNavigationBarPages();
        // View pages
        return view('templates/memberTemplates/header', $data)
             . view('pages/golf/members_golf')
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
        if (!session()->has('isLoggedIn'))
        {
            return redirect()->to(site_url('/home?error=not_logged_in'));
        }
        if ($requestType == "POST") // If the booking request is made
        {
            $GolfManager = model('GolfManagement');
            if (count($GolfManager->GetBookingAtTime($_POST['date'], $_POST['time'])) != 0)
            {
                return redirect()->to(site_url('/golf?error=invalid_override'));
            } else {
                $booking_successful = $GolfManager->CreateBooking($_POST['date'], $_POST['time'], [$_POST['plr_2_id'], $_POST['plr_3_id'], $_POST['plr_4_id']]);
                $date = $_POST['date'];
                if ($booking_successful)
                {
                    return redirect()->to(site_url("/golf?message=booking_successful&date=$date"));
                }
                else
                {
                    return redirect()->to(site_url("/golf?error=booking_unsuccessful&date=$date"));
                }
            }
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

    public function booking($bookingId, $editType)
    {
        $data['id'] = $bookingId;
        if ($editType == 'GET')
        {
            $GolfManager = model("GolfManagement");
            // Login security check
            if (!session()->has('isLoggedIn'))
            {
                return redirect()->to(site_url('/home?error=not_logged_in'));
            }
            // Check the user has access to the page
            $data['userOwnsBooking'] = false;
            $data['userIsStaffMember'] = false;
            $bookingInfo = $GolfManager->GetBookingFromId($bookingId);
            if (count($bookingInfo) == 0)
            {
                return redirect()->to(site_url('/golf?error=booking_not_found'));
            }
            if ($bookingInfo['id'] == $bookingId)
            {
                $data['userOwnsBooking'] = true;
            }
            if (session()->get('privilegeLevel') >= 5)
            {
                $data['userIsStaffMember'] = true;
            }

            $data['bookingInfo'] = $bookingInfo;
            $data['title'] = 'Edit Booking';
            $data['nav_pages'] = $this->getNavigationBarPages();
            $data['times_on_day'] = model("API")->GetAvailableTimesForDate($bookingInfo['date']);
            return view('templates/memberTemplates/header', $data)
                . view('pages/golf/booking_edit', $data)
                . view('templates/memberTemplates/footer');
        }
        elseif ($editType == 'POST')
        {
            if ($_POST['date'] == '' && $_POST['time'] == '' && $_POST['plr2'] == '' && $_POST['plr3'] == '' && $_POST['plr4'] == '')
            {
                return redirect()->to(site_url('/golf?error=no_changes'));
            }
            else
            {
                $details = [];
                $details['id'] = $bookingId;
                for ($i = 0; $i < count($_POST); $i++)
                {
                    $details[array_keys($_POST)[$i]] = $_POST[array_keys($_POST)[$i]];
                }
                if (model("GolfManagement")->EditBooking($details)) {
                    return redirect()->to(site_url('/golf?message=edit_successful'));
                } else {
                    return redirect()->to(site_url('/golf?error=edit_failed'));
                }
            }
        }
    }

    public function deleteBooking()
    {
        $GolfManager = model("GolfManagement");
        if (!session()->has('isLoggedIn'))
        {
            return redirect()->to(site_url('/home?error=not_logged_in'));
        } else {
            $bookingResult = $GolfManager->GetBookingFromId($_POST['deleteId']);
            if (count($bookingResult) == 0)
            {
                return redirect()->to(site_url('/golf?error=booking_not_found'));
            } else {
                if (session()->get('userId') == $bookingResult['players'][0][0])
                {
                    // Delete the booking
                    if ($GolfManager->DeleteBooking($_POST['deleteId'])) {
                        return redirect()->to(site_url('/golf?message=booking_deleted'));
                    } else {
                        return redirect()->to(site_url('/golf?error=unknown_deletion_error'));
                    }
                }
                else
                {
                    return redirect()->to(site_url('/golf?error=invalid_selection'));
                }
            }
        }
    }
}