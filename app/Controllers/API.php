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
        $formatted_date = $_GET['date'];
        if (!strpos($_GET['date'], '-'))
        {
            $date = \DateTime::createFromFormat('d/m/Y', $_GET['date']);
            $formatted_date = $date->format('Y-m-d');
        }
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
        $formatted_date = $_GET['date'];
        if (!strpos($_GET['date'], '-'))
        {
            $date = \DateTime::createFromFormat('d/m/Y', $_GET['date']);
            $formatted_date = $date->format('Y-m-d');
        }
        $APIModel = model("API");
        return json_encode($APIModel->GetAvailableTimesForDate($formatted_date));
    }

    public function memberIdGet($memberId)
    {
        $isLoggedIn = session()->get('isLoggedIn');
        // Redirect the user if they are not logged in as a member or visitor
        if (!$isLoggedIn)
        {
            return json_encode(array('error'=>"Access Denied", 'message'=>'An account must be logged in to use this API.'));
        }
        //
        $APIModel = model("API");
        return json_encode($APIModel->GetMemberById($memberId));
    }

    public function advancedMemberGet($userId)
    {
        $isLoggedIn = session()->get('isLoggedIn');
        // Redirect the user if they are not logged in as a member or visitor
        if (!$isLoggedIn)
        {
            return json_encode(array('error'=>"Access Denied", 'message'=>'An account must be logged in to use this API.'));
        } elseif (session()->has('privilegeLevel') && session()->get('privilegeLevel') < 5)
        {
            return json_encode(array('error'=>"Access Denied", 'message'=>'This account doesn\'t have permission to use this API method'));
        }
        //
        $APIModel = model("API");
        return json_encode($APIModel->AdvancedMemberGet($userId));
    }

    public function basket()
    {
        if ($_POST['operation'] == 'ADD')
        {
            $APIModel = model("API");
            return json_encode(array('newQuantity' => $APIModel->AddToBasket($_POST['productId'])));
        }
    }

    public function clearBasket()
    {
        try
        {
            model("API")->ClearUserBasket(session()->get('userId'));
            return json_encode(array('success'=>true));
        }
        catch (Exception $e)
        {
            return json_encode(array('success'=>false));
        }
    }

    public function removeBasketItem()
    {
        try
        {
            $result = model("API")->RemoveFromBasket($_POST['productId'], $_POST['quantity']);
            return json_encode(array('success'=>true, 'message'=>$result));
        }
        catch (Exception $e)
        {
            return json_encode(array('success'=>false, 'message'=>'Unknown Error'));
        }
    }

    public function placeOrder()
    {
        try {
            model("API")->TransferToOrder();
            return json_encode(array('success'=>true));
        } catch(Exception $e)
        {
            return json_encode(array('success'=>false));
        }
    }
}