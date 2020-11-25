<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;
    
    private $response;
    
    public function __construct()
    {
        $this->response['status'] = true;
    }
    
    /**
     * Update session
     *
     * @param array $where
     * @param array $data
     *
     * @return mixed
     */
    public function updateSession(array $where, array $data)
    {
        try {
            $this->where($where)->update($data);
        } catch (\Exception $ex) {
            logger()->error('Error Model->Session updateSession => ' . $ex->getMessage());
            $this->response['status'] = false;
            $this->response['message'] = 'Unexpected Error.';
        }
        
        return $this->response;
    }
    
    /**
     * Get session
     *
     * @param array $where
     * @param array $columns
     *
     * @return mixed
     */
    public function getSession(array $where, array $columns)
    {
        try {
            $result = $this->select($columns)->where($where)->get()->toArray();
            if (empty($result[0])) {
                $this->response['status'] = false;
                $this->response['message'] = 'Invalid or expired token.';
                $this->response['data'] = $result[0];
                return $this->response;
            }
            $this->response['data'] = $result[0];
        } catch (\Exception $ex) {
            logger()->error('Error Model->Session getSession => ' . $ex->getMessage());
            $this->response['status'] = false;
            $this->response['message'] = 'Unexpected Error.';
        }
        
        return $this->response;
    }
    
    public function insertSession(string $userId, string $sessionId)
    {
        $this->user_id = $userId;
        $this->session = $sessionId;
        
        try {
            $this->save();
        } catch (\Exception $ex) {
            logger()->error('Error Models->Session insertSession => ' . $ex->getMessage());
            $this->response['status'] = false;
            $this->response['message'] = 'Unexpected Error.';
        }
        $this->response['status'] = true;
        return $this->response;
    }
}
