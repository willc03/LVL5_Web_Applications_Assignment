<?php

namespace App\Models;
use CodeIgniter\Model;
use CodeIgniter\Database\RawSql;

class GolfManagement extends Model
{
    /*
     * This method will be used to get the times on a day when golf can be booked according to the database.
     * For note, the first row of the table is the default data that will be used if no times exist.
     */
    public function GetTimesForDate($date)
    {
        $db = db_connect(); // Connect to the database using the default credentials
        $builder = $db->table("GolfTimes"); // Set the active table to GolfTimes
        $escapedDate = $db->escape($date); // Prevents SQL injection
        $results = $builder->getWhere("$escapedDate BETWEEN StartDate AND EndDate"); // Query results where the row's dates contain the date provided
        // Return the relevant results to the player
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

    public function GetAllTimes()
    {
        $startTime = strtotime('12:00 AM');
        $endTime = strtotime('11:50 PM');

        $current = $startTime;
        $times = [];
        while ($current <= $endTime) {
            $times[] = date('h:i A', $current);
            $current += 600; // 10 minutes in seconds
        }
        return $times;
    }

    public function GetAllIncrements()
    {
        $increments = array();
        for ($i = 300; $i <= 3600; $i += 300) {
            $increments[] = gmdate("H:i:s", $i);
        }
        return $increments;
    }

    public function GetTimeSettingsOnDate($date)
    {
        $db = db_connect(); // Connect to the database using the default credentials
        $builder = $db->table("GolfTimes"); // Set the active table to GolfTimes
        $escapedDate = $db->escape($date); // Prevents SQL injection
        $results = $builder->getWhere("$escapedDate BETWEEN StartDate AND EndDate"); // Query results where the row's dates contain the date provided
        // Return the relevant results to the player
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
            $default_time_settings = $results->getResultArray()[count($results->getResultArray())-1];
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
        return array($availableTimes, $default_time_settings["StartDate"], $default_time_settings["EndDate"], $default_time_settings["TimeIncrement"], $default_time_settings['TimeId']);
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

            $players[] = array($bookerDetails['UserId'], $bookerDetails['Firstname'] . ' ' . $bookerDetails['Lastname']);

            foreach ($playerQuery->getResultArray() as $player) {
                $playerId = $player['PlayerId'];
                if ($playerId != $bookerDetails['UserId']) {
                    $playerResult = $userBuilder->getWhere("UserId = $playerId")->getResultArray()[0];
                    $players[] = array($playerResult['UserId'], $playerResult['Firstname'] . ' ' . $playerResult['Lastname']);
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

    public function GetBookingFromId($id)
    {
        $db = db_connect();
        $builder = $db->table('GolfBooking');

        // Escape the booking ID
        $id = esc($id);
        $id = intval($id);
        // Retrieve booking data
        $query = $builder->getWhere("BookingId = $id");
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

            $players[] = array($bookerDetails['UserId'], $bookerDetails['Firstname'] . ' ' . $bookerDetails['Lastname']);

            foreach ($playerQuery->getResultArray() as $player) {
                $playerId = $player['PlayerId'];
                if ($playerId != $bookerDetails['UserId']) {
                    $playerResult = $userBuilder->getWhere("UserId = $playerId")->getResultArray()[0];
                    $players[] = array($playerResult['UserId'], $playerResult['Firstname'] . ' ' . $playerResult['Lastname']);
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

    public function DeleteBooking($id)
    {
        $db = db_connect();
        $builder = $db->table('GolfBooking');

        // Escape the booking ID
        $id = esc($id);
        // Retrieve booking data
        $query = $builder->getWhere("BookingId = $id");
        $results = $query->getResultArray();

        // Return the booking data with player information
        if ($results) {
            $results = $results[0];
            $bookingId = $results['BookingId'];

            $playerBuilder = $db->table('GolfBookingPlayers');
            $playerBuilder->delete(['BookingId'=>$bookingId]);

            $builder->delete(['BookingId'=>$id]);

            return true;
        }

        return false;
    }

    public function createBooking($date, $time, $players)
    {
        $db = db_connect();
        $bookingBuilder = $db->table('GolfBooking');
        $playerBuilder = $db->table('GolfBookingPlayers');

        // Handle the booking data first
        $query_time = date('H:i:s', strtotime(esc($time)));
        $insert_successful = $bookingBuilder->insert([
            'UserId' => session()->get('userId'),
            'BookingDate' => $date,
            'BookingTime' => $query_time
        ]);

        if (!$insert_successful) {
            return false;
        }

        // Get the ID of the booking
        $booking = $this->getBookingAtTime($date, $query_time);
        if (count($booking) == 0) {
            return false;
        }

        // Now add the players to the database
        foreach ($players as $playerId) {
            if ($playerId == '-1') {
                continue;
            }

            if (!$playerBuilder->insert([
                'BookingId' => $booking['id'],
                'PlayerId' => $playerId
            ])) {
                return false;
            }
        }

        return true;
    }

    public function EditBooking($details)
    {
        try {
            $db = db_connect();

            // Update the booking first
            $bookingBuilder = $db->table('GolfBooking');

            $data = [];
            if ($details['date'] != '')
            {
                if (!strpos($details['date'], '-'))
                {
                    $details['date'] = \DateTime::createFromFormat('d/m/Y', $details['date']);
                    $details['date'] = $details['date']->format('Y-m-d');
                }
                $data['BookingDate'] = date('Y-m-d', strtotime($details['date']));
            }
            if ($details['time'] != '')
            {
                $data['BookingTime'] = date('H:i:s', strtotime($details['time']));
            }
            $bookingBuilder->update($data, 'BookingId = ' . $details['id']);

            // Then handle the players
            $playerBuilder = $db->table('GolfBookingPlayers');

            $bookingId = $details['id'];
            $playerBuilder->delete("BookingId = $bookingId");

            if ($details['plr2'] != 'null' && $details['plr2'] != 'rem')
            {
                $playerId = $details['plr2'];
                $playerBuilder->insert(['BookingId' => $bookingId, 'PlayerId' => $playerId]);
            }

            if ($details['plr3'] != 'null' && $details['plr3'] != 'rem')
            {
                $playerId = $details['plr3'];
                $playerBuilder->insert(['BookingId' => $bookingId, 'PlayerId' => $playerId]);
            }

            if ($details['plr4'] != 'null' && $details['plr4'] != 'rem')
            {
                $playerId = $details['plr4'];
                $playerBuilder->insert(['BookingId' => $bookingId, 'PlayerId' => $playerId]);
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}