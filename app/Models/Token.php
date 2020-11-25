<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    private $response;
    
    public function __construct()
    {
        $this->response['status'] = true;
    }
    
    /**
     * Check token
     *
     * @param string $token
     *
     * @return mixed
     */
    public function checkToken(string $token)
    {
        try {
            $result = $this->response['data'] = $this->select('user_id')
                ->where([['token', '=', $token], ['expiration_date', '>', Carbon::now()]])
                ->get()
                ->toArray();
            if (empty($result[0])) {
                $this->response['status'] = false;
                $this->response['message'] = 'Invalid or expired token.';
                return $this->response;
            }
            $this->response['data'] = $result[0];
        } catch (\Exception $ex) {
            logger()->error('Error Model->Token checkToken => ' . $ex->getMessage());
            $this->response['status'] = false;
            $this->response['message'] = 'Unexpected Error.';
        }
        
        return $this->response;
    }
    
    /**
     * Get token
     *
     * @param array $columns
     * @param array $where
     *
     * @return mixed
     */
    public function get(array $columns, array $where)
    {
        try {
            $result = $this->response['data'] = $this->select($columns)->where($where)->get()->toArray();
            if (empty($result[0])) {
                $this->response['status'] = false;
                $this->response['message'] = 'Invalid or expired token.';
                return $this->response;
            }
            $this->response['data'] = $result[0];
        } catch (\Exception $ex) {
            logger()->error('Error Model->Token get => ' . $ex->getMessage());
            $this->response['status'] = false;
            $this->response['message'] = 'Unexpected Error.';
        }
        
        return $this->response;
    }
    
    /**
     * Insert token
     * @param string $token
     * @param array $data
     *
     * @return mixed
     */
    public function insertToken(string $token, array $data)
    {
        $this->user_id = $data['id'];
        $this->token = $token;
        $this->expiration_date = Carbon::now()->addHour();
        try {
            $this->save();
        } catch (\Exception $ex) {
            logger()->error('Error Models->Token insertToken => ' . $ex->getMessage());
            $this->response['status'] = false;
            $this->response['message'] = 'Unexpected Error.';
        }
        $this->response['status'] = true;
        
        return $this->response;
    }
    
    public function updateToken(array $data, array $where)
    {
        try {
            $this->where($where)->update($data);
        } catch (\Exception $ex) {
            logger()->error('Error Model->Token updateToken => ' . $ex->getMessage());
            $this->response['status'] = false;
            $this->response['message'] = 'Unexpected Error.';
        }
        
        return $this->response;
    }
}
