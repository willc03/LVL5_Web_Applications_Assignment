<?php

namespace App\Models;
use CodeIgniter\Model;

class UserAuthentication extends Model
{
    protected $table = 'User';
    private function ResolveUserFromEmail($email): bool
    {
        $db = db_connect(); // Connect to the database using the default privileges.

        $builder = $db->table('Users'); // Set the table to 'Users'
        $results = $builder->getWhere(['Email'=>$email]); // Set the query to only return results where the email is matched.

        $db->close(); // Close the active database connection
        return count($results->getResultArray()) == 1; // Return true if the result is 1, indicating the user exists.
    }

    {

        $db->close();

    }

}