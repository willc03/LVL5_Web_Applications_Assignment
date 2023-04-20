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

    /**
     * This function will return the details of a booking that is made
     * at the date and time provided (if it exists)
     *
     * @param $date
     * @param $time
     * @return array
     */
    public function GetBookingAtTime($date, $time): array
    {
        $db = db_connect();
        $builder = $db->table('GolfBooking');

        // Escape and format input data
        $query_date = date('Y-m-d', strtotime(esc($date)));
        $query_time = date('H:i:s', strtotime(esc($time)));

        // Retrieve booking data
        $query = $builder->getWhere("BookingDate = '$query_date' AND BookingTime = '$query_time'");
        $results = $query->getResultArray();

        // Return the booking data with player information
        if ($results) {
            $results = $results[0];
            $bookingId = $results['BookingId'];
            $bookerId = $results['UserId'];

            $playerBuilder = $db->table('GolfBookingPlayers');
            $playerQuery = $playerBuilder->getWhere("BookingId = $bookingId");
            $players = [];

            $userBuilder = $db->table('Users');
            $bookerResult = $userBuilder->getWhere("UserId = $bookerId");
            $bookerDetails = $bookerResult->getResultArray()[0];

            $players[] = $bookerDetails['Firstname'] . ' ' . $bookerDetails['Lastname'];

            foreach ($playerQuery->getResultArray() as $player) {
                $playerId = $player['PlayerId'];
                if ($playerId != $bookerDetails['UserId']) {
                    $playerResult = $userBuilder->getWhere("UserId = $playerId")->getResultArray()[0];
                    $players[] = $playerResult['Firstname'] . ' ' . $playerResult['Lastname'];
                }
            }

            return [
                'id' => $results['BookingId'],
                'time' => $results['BookingTime'],
                'date' => $results['BookingDate'],
                'players' => $players,
            ];
        }

        return [];
    }


}