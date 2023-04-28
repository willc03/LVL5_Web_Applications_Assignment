<?php

namespace App\Models;
use CodeIgniter\Model;
use CodeIgniter\Database\RawSql;

class API extends Model
{
    public function GetMembers(): array
    {
        $db = db_connect();
        $builder = $db->table("Users");
        $results = $builder->get();
        // Return the relevant results to the player
        $names = array();
        foreach ($results->getResultArray() as $res)
        {
            $names[] = array( 'value'=>$res['UserId'], 'label'=>$res['Lastname'] . ', ' . $res['Firstname'] );
        }
        return $names;
    }
    public function GetBooking($date, $time)
    {
        $GolfManager = model("GolfManagement");
        return $GolfManager->GetBookingAtTime($date, $time);
    }
    public function GetAvailableTimesForDate($date)
    {
        $GolfMananger = model("GolfManagement");
        $timesForDate = $GolfMananger->GetTimesForDate($date);
        // Check each time
        $times = [];
        foreach ($timesForDate as $time)
        {
            if (count($GolfMananger->GetBookingAtTime($date, $time)) == 0)
            {
                $times[] = array($time, 0);
            }
            else
            {
                $times[] = array($time, 1);
            }
        }
        return $times;
    }

    public function GetMemberById($id)
    {
        $db = db_connect();
        $builder = $db->table("Users");
        $results = $builder->getWhere("UserId = $id");
        // Return the relevant results to the player
        $res = $results->getResultArray()[0];
        $res['Password'] = "";
        $res['Address'] = "";
        $res['DateOfBirth'] = "";
        return $res;
    }

    public function AdvancedMemberGet($id)
    {
        $db = db_connect('admin'); // Admin privilege is used to get the sensitive information
        $builder = $db->table("Users");
        $results = $builder->getWhere("UserId = $id");
        // Return the relevant results to the player
        $res = $results->getResultArray()[0];
        unset($res['Password']);
        return $res;
    }

    public function UpdateUser($data)
    {
        $db = db_connect('admin'); // Admin privilege is used to SET the sensitive information
        $builder = $db->table("Users");

        $dateObj = \DateTime::createFromFormat('d/m/Y', $data['dob']);
        $formattedDate = $dateObj->format('Y-m-d');

        $db_data = [
            'Firstname' => $data['fname'],
            'Lastname' => $data['lname'],
            'Address' => $data['ad1'] . ', ' . $data['ad2'] . ', ' . $data['town'] . ', ' . $data['county'] . ', ' . $data['pcode'],
            'Email' => $data['email'],
            'DateOfBirth' => $formattedDate,
            'PrivilegeLevel' => $data['u_lvl']
        ];

        $userId = $data['uid'];
        $worked = $builder->update($db_data, "UserId = $userId");
        return $worked;
    }

    public function RemoveGolfTimeSet($data)
    {
        $db = db_connect('admin');
        $builder = $db->table('GolfTimes');
        $builder->delete("TimeId = $data");
    }

    public function AddGolfTimeSet($data)
    {
        $db = db_connect('admin');
        $builder = $db->table('GolfTimes');
        $builder->insert([
            'StartDate' => date('Y-m-d', strtotime($data['startDate'])),
            'EndDate' => date('Y-m-d', strtotime($data['endDate'])),
            'StartTime' => model("GolfManagement")->GetAllTimes()[$data['stime']],
            'EndTime' => model("GolfManagement")->GetAllTimes()[$data['etime']],
            'TimeIncrement' => model("GolfManagement")->GetAllIncrements()[$data['timeinc']],
        ]);
    }

    public function AddToBasket($productId)
    {
        $db = db_connect('member');
        $builder = $db->table('BasketContents');
        $results = $builder->getWhere(['ProductId'=>$productId, 'UserId'=>session()->get('userId')]);
        if (!$results || count($results->getResultArray()) == 0)
        {
            $builder->where(['ProductId' => $productId, 'UserId' => session()->get('userId')]);
            $builder->insert([
                'ProductId' => $productId,
                'Quantity' => 1,
                'UserId' => session()->get('userId')
            ]);
            return 1;
        }
        elseif ($results && count($results->getResultArray()) > 0)
        {
            $results = $builder->getWhere(['ProductId' => $productId, 'UserId' => session()->get('userId')]);
            //echo $results;
            $builder->where(['ProductId' => $productId, 'UserId' => session()->get('userId')]);
            $builder->update([
                'Quantity' => $results->getResultArray()[0]['Quantity'] + 1,
            ]);
            return $results->getResultArray()[0]['Quantity'] + 1;
        }
    }

    public function ClearUserBasket($UserId)
    {
        $db = db_connect('member');
        $builder = $db->table('BasketContents');
        $builder->where(['UserId'=>$UserId]);
        $builder->delete();
    }

    public function RemoveFromBasket($productId, $quantity)
    {
        $db = db_connect('member');
        $builder = $db->table('BasketContents');
        $results = $builder->getWhere(['ProductId'=>$productId, 'UserId'=>session()->get('userId')]);
        if (!$results || count($results->getResultArray()) == 0)
        {
            return false;
        }
        elseif ($results && count($results->getResultArray()) > 0)
        {
            $results = $builder->getWhere(("ProductId = $productId AND UserId = " . session()->get('userId')));
            if ($quantity == '*')
            {
                $quantity = $results->getResultArray()[0]['Quantity'];
            }
            $builder->where(['ProductId' => $productId, 'UserId' => session()->get('userId')]);
            if ($results->getResultArray()[0]['Quantity'] - $quantity <= 0 )
            {
                $builder->delete();
                return 0;
            }
            else
            {
                $builder->update([
                    'Quantity' => $results->getResultArray()[0]['Quantity'] - $quantity,
                ]);
                return $results->getResultArray()[0]['Quantity'] - $quantity;
            }
        }
    }

    public function TransferToOrder()
    {
        $db = db_connect("member");

        // Get basket items
        $builder = $db->table("BasketContents");
        $items = $builder->getWhere(['UserId' => session()->get('userId')]);

        if ($items)
        {
            $orderBuilder = $db->table("Orders");

            // Build the order
            $orderBuilder->insert([
                'UserId' => session()->get("userId")
            ]);
            $orderIdGet = $orderBuilder->getWhere(['UserId'=>session()->get('userId')]);
            $orderIdRes = $orderIdGet->getResultArray();
            $orderIdResCont = end($orderIdRes);
            $orderId = $orderIdResCont['OrderId'];
            // Add the items
            $orderItemBuilder = $db->table("OrderItems");
            foreach($items->getResultArray() as $res)
            {
                $orderItemBuilder->insert([
                    'OrderId' => $orderId,
                    'ItemId' => $res['ProductId'],
                    'Quantity' => $res['Quantity']
                ]);
            }

            $this->ClearUserBasket(session()->get("userId"));
        }

    }

}