<?php

namespace App\Models;
use CodeIgniter\Model;

class UserAuthentication extends Model
{
    protected $db;
    //Setup
    protected $table      = 'Users';
    protected $primaryKey = 'UserId';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function resolveUserFromEmail($email)
    {
        $query = $this->db->query("SELECT * FROM Users WHERE Email = '$email';");
        $result = $query->getResultArray();
        return $result;
    }

    public function checkUserPassword($email, $password)
    {
        $db = \Config\Database::connect('default');
        $query = $db->query("SELECT Email, Password FROM Users WHERE Email = \'$email\'");
        $result = $query->getResultArray();
        if ( count($result) == 1 )
        {
            if ( password_verify($password, $result[0][1]) )
            {
                return 2;
            }
            else
            {
                return 1;
            }
        } 
        else 
        {
            return 0;
        }

        $db->close();
    }

}