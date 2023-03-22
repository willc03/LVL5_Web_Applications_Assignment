<?php

namespace App\Models;
use CodeIgniter\Model;

class UserAuthentication extends Model
{
    /**
     * This method will be used to check if a user exists. The email parameter is used to check the email
     * against the rest of the database.
     *
     * The result of this method is a Boolean. True will be returned if the result is 1, as this indicates
     * that the user exists, false will be returned if this is not the case.
     *
     * @param $email
     * @return bool
     */
    private function ResolveUserFromEmail($email): bool
    {
        $db = db_connect(); // Connect to the database using the default privileges.

        $builder = $db->table('Users'); // Set the table to 'Users'
        $results = $builder->getWhere(['Email'=>$email]); // Set the query to only return results where the email is matched.

        $db->close(); // Close the active database connection
        return count($results->getResultArray()) == 1; // Return true if the result is 1, indicating the user exists.
    }

    /**
     * This function will take in the email and password submitted in the form
     * and check the existing hashed password against the values submitted.
     *
     * @param $email
     * @param $password
     * @return bool
     */
    private function CheckPasswordAgainstHash($email, $password): bool
    {
        $db = db_connect();

        $builder = $db->table('Users');
        $results = $builder->getWhere(['Email'=>$email]);
        $resultArray = $results->getResultArray();

        $hashedPassword = $resultArray[0]["Password"]; // The hashed password will be used in the verification function

        $db->close();
        return password_verify($password, $hashedPassword); // Returns a boolean of true if the password matches the hash
    }

    /**
     * This publicly accessible function is a gateway between the private functions
     * and other classes.
     *
     * The function will check if the user exists, and if it does, will verify the
     * password is correct. The result of this will be returned to the user.
     *
     * @param $email
     * @param $password
     * @return string
     */
    public function AuthenticateUser($email, $password): string
    {

        $DoesUserExist = $this->ResolveUserFromEmail($email);
        if (!$DoesUserExist)
        {
            return "There is no user with the provided email address."; // The user doesn't exist, so an error message is returned.
        }
        else
        {
            $IsPasswordCorrect = $this->CheckPasswordAgainstHash($email, $password);
            if ($IsPasswordCorrect)
            {
                return "Success";
            }
            else
            {
                return "IncorrectPwd";
            }
        }

    }

}