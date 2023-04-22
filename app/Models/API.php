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
                $times[] = array($time, false);
            }
            else
            {
                $times[] = array($time, true);
            }
        }
        return $times;
    }
}