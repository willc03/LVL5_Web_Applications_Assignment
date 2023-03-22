<?php

namespace App\Models;
use CodeIgniter\Model;

class UserAuthentication extends Model
{
    protected $table = 'User';
    public function ResolveUserFromEmail($email)
    {
        $db = db_connect(); // Connect to the database using the default privileges.

        $builder = $db->table('Users'); // Set the table to 'Users'
        $builder->getWhere(['Email'=>$_POST['email']]); // Set the query to only return results where the email is matched.

        $db->close(); // Close the active database connection
        return $builder->countAllResults(false) == 1; // Return true if the result is 1, indicating the user exists.
    }

    public function checkUserPassword($email, $password)
    {
        $db = \Config\Database::connect();
        $query = $db->query('SELECT Email, Password FROM Users WHERE Email = ' . $email . ';');

        $db->close();
        return $query->getResultArray();

    }

}