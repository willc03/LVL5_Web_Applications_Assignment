<?php

namespace App\Models;
use CodeIgniter\Model;
use CodeIgniter\Database\RawSql;

class GolfManagement extends Model
{
    /**
     * This method will be used to get the times on a day when golf can be booked according to the database.
     * For note, the first row of the table is the default data that will be used if no times exist.
     *
     * @param $date
     * @return array
     */
    public function GetTimesForDate($date): array
    {
        $db = db_connect(); // Connect to the database using the default credentials
        $builder = $db->table("GolfTimes"); // Set the active table to GolfTimes
        $escapedDate = $db->escape($date); // Prevents SQL injection
        $results = $builder->getWhere("$escapedDate BETWEEN StartDate AND EndDate"); // Query results where the row's dates contain the date provided
        // Return the relevant results to the player
        $default_time_settings = null;
        $availableTimes = array();
        if (!$results || count($results->getResultArray()) == 0)
        {
            // There were no set times found
            $default_results = $builder->getWhere("TimeId = 1")->getResultArray();
            $default_time_settings = $default_results[0];

        }
        else
        {
            // Times found
            $default_time_settings = $results->getResultArray()[0];
        }

        $start_time = strtotime($default_time_settings["StartTime"]);
        $end_time = strtotime($default_time_settings["EndTime"]);
        $current_time = $start_time;
        while ($current_time <= $end_time) {
            $availableTimes[] = date('g:i A', $current_time);
            list($hours, $minutes, $seconds) = explode(':', $default_time_settings["TimeIncrement"]);
            $elapsed_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;
            $current_time += $elapsed_seconds;
        }

        return $availableTimes;
    }

}