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
}