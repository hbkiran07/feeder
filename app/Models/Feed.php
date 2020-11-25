<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    private $response;
    
    public function __construct()
    {
        $this->response['status'] = true;
    }
    
    /**
     * Get feed
     *
     * @param array $where
     * @param array $columns
     *
     * @return mixed
     */
    public function getFeed(array $where, array $columns)
    {
        try {
            $this->response['data'] = $this->select($columns)->where($where)->get()->toArray();
        } catch (\Exception $ex) {
            logger()->error('Error Model->Feed getFeed => ' . $ex->getMessage());
            $this->response['status'] = false;
            $this->response['message'] = 'Unexpected Error.';
        }
        
        return $this->response;
    }
    
    /**
     * Update feed
     *
     * @param array $where
     * @param array $data
     *
     * @return mixed
     */
    public function updateFeed(array $where, array $data)
    {
        try {
            $this->where($where)->update($data);
        } catch (\Exception $ex) {
            logger()->error('Error Model->Feed updateFeed => ' . $ex->getMessage());
            $this->response['status'] = false;
            $this->response['message'] = 'Unexpected Error.';
        }
        
        return $this->response;
    }
    
    /**
     * Check data owner
     *
     * @param int $userId
     * @param int $feedId
     *
     * @return mixed
     */
    public function checkDataOwner(int $userId, int $feedId)
    {
        try {
            $count = $this->where([['user_id', '=', $userId], ['id', '=', $feedId]])->count();
            logger()->info($count);
            if ($count == 0) {
                $this->response['status'] = false;
                $this->response['message'] = 'No such data was found.';
                return $this->response;
            }
        } catch (\Exception $ex) {
            logger()->error('Error Model->Feed checkDataOwner => ' . $ex->getMessage());
            $this->response['status'] = false;
            $this->response['message'] = 'Unexpected Error.';
        }
        
        return $this->response;
    }
    
    /**
     * Get feed all published and all user with paginated
     *
     * @return mixed
     */
    public function getFlow()
    {
        try {
            $result = $this->select('user_name', 'data')
                ->where('status', '=', 1)
                ->orderBy('updated_at', 'desc')
                ->paginate(config('app.twitter_feeder_data_count'))
                ->toArray();
            $this->response['data'] = $result['data'];
        } catch (\Exception $ex) {
            logger()->error('Error Model->Feed getFlow => ' . $ex->getMessage());
            $this->response['status'] = false;
            $this->response['message'] = 'Unexpected Error.';
        }
        
        return $this->response;
    }
    
    /**
     * Insert data
     *
     * @param array $data
     *
     * @return mixed
     */
    public function insertSource(array $data)
    {
        try {
            $this->insert($data);
        } catch (\Exception $ex) {
            logger()->error('Error Models->Feed insertSource => ' . $ex->getMessage());
            $this->response['status'] = false;
            $this->response['message'] = 'Unexpected Error.';
        }
        
        return $this->response;
    }
}
