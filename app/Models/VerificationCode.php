<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    use HasFactory;
    
    private $response;
    
    public function __construct()
    {
        $this->response['status'] = true;
    }
    
    /**
     * Insert
     *
     * @param array $userData
     * @param string $smsCode
     * @param string $emailCode
     *
     * @return mixed
     */
    public function insert(array $userData, string $smsCode, string $emailCode)
    {
        $this->user_id = $userData['id'];
        $this->user_name = $userData['user_name'];
        $this->user_email = $userData['email'];
        $this->email_code = $emailCode;
        $this->sms_code = $smsCode;
        $this->status = config('constants.status.passive');
        try {
            $this->save();
        } catch (\Exception $ex) {
            logger()->error('Error Model->VerificationCode insert => ' . $ex->getMessage());
            $this->response['status'] = false;
            $this->response['message'] = 'Unexpected Error.';
        }
        
        return $this->response;
    }
    
    /**
     * Get data
     *
     * @param array $data
     *
     * @return mixed
     */
    public function getData(array $data)
    {
        try {
            $result = $this->select('user_name', 'user_email', 'email_code', 'sms_code', 'status')->where($data)->get()->toArray();
            if (empty($result[0])) {
                $this->response['status'] = false;
                return $this->response;
            }
            $this->response['data'] = $result[0];
        } catch (\Exception $ex) {
            logger()->error('Error Model->VerificationCode getData => ' . $ex->getMessage());
            $this->response['status'] = false;
            $this->response['message'] = 'Unexpected Error.';
        }
        
        return $this->response;
    }
    
    /**
     * Update verification
     *
     * @param array $where
     * @param array $data
     *
     * @return mixed
     */
    public function updateVerification(array $where, array $data)
    {
        try {
            $this->where($where)->update($data);
        } catch (\Exception $ex) {
            logger()->error('Error Model->VerificationCode updateVerification => ' . $ex->getMessage());
            $this->response['status'] = false;
            $this->response['message'] = 'Unexpected Error.';
        }
        
        return $this->response;
    }
}
