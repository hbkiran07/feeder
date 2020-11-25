<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    use HasFactory;
    
    private $response;
    
    public function __construct()
    {
        $this->response['status'] = true;
    }
    
    /**
     * Insert user
     *
     * @param array $data
     *
     * @return mixed
     */
    public function insert(array $data)
    {
        $this->name = $data['name'];
        $this->surname = $data['surname'];
        $this->user_name = $data['userName'];
        $this->email = $data['email'];
        $this->password = Hash::make($data['password']);
        $this->phone_number = $data['phoneNumber'];
        $this->feeder_platform = $data['feederPlatform'];
        $this->feeder_address = $data['feederAddress'];
        try {
            $this->save();
        } catch (\Exception $ex) {
            logger()->error('Error Models->User insert => ' . $ex->getMessage());
            $this->response['status'] = false;
            $this->response['message'] = 'Unexpected Error.';
        }
        $this->response['data'] = $this->attributes;
        
        return $this->response;
    }
    
    /**
     * Remove user
     *
     * @param array $data
     *
     * @return mixed
     */
    public function remove(array $data)
    {
        try {
            $this->delete($data);
        } catch (\Exception $ex) {
            logger()->error('Error Model->User remove => ' . $ex->getMessage());
            $this->response['status'] = false;
            $this->response['message'] = 'Unexpected Error.';
        }
        
        return $this->response;
    }
    
    /**
     * Check user exist
     *
     * @param array $where
     *
     * @return mixed
     */
    public function checkExist(array $where)
    {
        try {
            $count = $this->where($where)->count();
            if ($count > 0) {
                $this->response['status'] = false;
                return $this->response;
            }
        } catch (\Exception $ex) {
            logger()->error('Error Model->User checkExist => ' . $ex->getMessage());
            $this->response['status'] = false;
            $this->response['message'] = 'Unexpected Error.';
        }
        
        return $this->response;
    }
    
    /**
     * Get data
     *
     * @param array $where
     * @param array $columns
     *
     * @return mixed
     */
    public function getData(array $where, array $columns)
    {
        try {
            $result = $this->select($columns)->where($where)->get()->toArray();
            if (empty($result[0])) {
                $this->response['status'] = false;
            } else {
                $this->response['data'] = $result[0];
            }
        } catch (\Exception $ex) {
            logger()->error('Error Model->User getData => ' . $ex->getMessage());
            $this->response['status'] = false;
            $this->response['message'] = 'Unexpected Error.';
        }
        
        return $this->response;
    }
    
}
