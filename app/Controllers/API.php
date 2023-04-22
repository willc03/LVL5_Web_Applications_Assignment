<?php
namespace App\Controllers;

use Cassandra\Date;

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
        $date = \DateTime::createFromFormat('d/m/Y', $_GET['date']);
        $formatted_date = $date->format('Y-m-d');
        return json_encode($APIModel->GetBooking($formatted_date, $_GET['time']));
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
        $date = \DateTime::createFromFormat('d/m/Y', $_GET['date']);
        $formatted_date = $date->format('Y-m-d');
        return json_encode($APIModel->GetAvailableTimesForDate($formatted_date));
    }
}