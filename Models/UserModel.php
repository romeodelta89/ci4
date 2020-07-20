<?php namespace Rudi\App\Models;

use CodeIgniter\Model;
use Rudi\App\Libraries\Token;

class UserModel extends Model
{
	protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username','email', 'password'];
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'username'              => 'required',
        'email'                 => 'required|valid_email',
        'password'              => 'required|min_length[6]',
        'password_confirmation' => 'required|matches[password]',
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected function hashPassword(array $data)
    {
        if (! isset($data['data']['password'])) return $data;
        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        // unset($data['data']['password']);
        return $data;
    }

}