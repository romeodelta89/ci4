<?php namespace Rudi\App\Models;

use CodeIgniter\Model;
use Rudi\App\Models\UserModel;

class UserLogin extends Model
{
	protected $table      = 'user_login';
    protected $primaryKey = 'id';
    protected $allowedFields = [];
    protected $beforeInsert = [];
    protected $beforeUpdate = [];

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;


    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    public function login()
    {
        if (!$email == null && $email == $this->where('email', $email)->first()['email']) {
            $user = $this->where('email', $email)->first();
            $claim =[
                'username'  => $user['username'],
                'email'     => $user['email'],
                'password'  => $user['password'],
            ];
            return Token::set(['user', $claim]);
        }
    }

}