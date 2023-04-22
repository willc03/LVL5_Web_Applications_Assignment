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
            return json_encode(array('error'=>"Access Denied", 'message'=>'An account must be logged in to use this API.'));
        }
        //
        $APIModel = model("API");
        return json_encode($APIModel->GetMembers());
    }

    public function bookingGet()
    {
        $isLoggedIn = session()->get('isLoggedIn');
        // Redirect the user if they are not logged in as a member or visitor
        if (!$isLoggedIn)
        {
            return json_encode(array('error'=>"Access Denied", 'message'=>'An account must be logged in to use this API.'));
        }
        //
        $APIModel = model("API");
        return json_encode($APIModel->GetBooking($_GET['date'], $_GET['time']));
    }

    public function timeGet()
    {
        $isLoggedIn = session()->get('isLoggedIn');
        // Redirect the user if they are not logged in as a member or visitor
        if (!$isLoggedIn)
        {
            return json_encode(array('error'=>"Access Denied", 'message'=>'An account must be logged in to use this API.'));
        }
        //
        $APIModel = model("API");
        return json_encode($APIModel->GetAvailableTimesForDate($_GET['date']));
    }
}