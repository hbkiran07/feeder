<?php

namespace App\Http\Controllers;

use App\Http\Feeders\IFeeder;
use App\Http\Responses\JsonResponse;
use App\Models\Feed;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FeederController extends Controller
{
    private $feed;
    
    public function __construct()
    {
        $feed = new Feed();
        $this->feed = $feed;
    }
    
    /**
     * Get user's feed data
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function getFeedData(Request $request)
    {
        $data = $this->feed->getFeed(
            [
                ['user_id', '=', $request->userId]
            ],
            ['id', 'user_name', 'data', 'status']
        );
        if (!$data['status']) {
            return response()->json([
                'success' => $data['status'],
                'message' => $data['message'],
            ])->setStatusCode(config('constants.status_codes.bad_request'));
        }
        
        return response()->json([
            'success' => $data['status'],
            'message' => 'Feeds successfully listed.',
            'data' => $data['data'],
        ])->setStatusCode(config('constants.status_codes.success'));
    }
    
    /**
     * User feeds get status active data.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function getActive(Request $request)
    {
        $data = $this->feed->getFeed(
            [
                ['user_id', '=', $request->userId],
                ['status', '=', config('constants.status.active')]
            ],
            ['id', 'user_name', 'data', 'status']
        );
        if (!$data['status']) {
            return response()->json([
                'success' => $data['status'],
                'message' => $data['message'],
            ])->setStatusCode(config('constants.status_codes.bad_request'));
        }
        
        return response()->json([
            'success' => $data['status'],
            'message' => 'Feeds successfully listed.',
            'data' => $data['data'],
        ])->setStatusCode(config('constants.status_codes.success'));
    }
    
    /**
     * User feeds get status passive data.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function getPassive(Request $request)
    {
        $data = $this->feed->getFeed(
            [
                ['user_id', '=', $request->userId],
                ['status', '=', config('constants.status.passive')]
            ],
            ['id', 'user_name', 'data', 'status']
        );
        if (!$data['status']) {
            return response()->json([
                'success' => $data['status'],
                'message' => $data['message'],
            ])->setStatusCode(config('constants.status_codes.bad_request'));
        }
        
        return response()->json([
            'success' => $data['status'],
            'message' => 'Feeds successfully listed.',
            'data' => $data['data'],
        ])->setStatusCode(config('constants.status_codes.success'));
    }
    
    /**
     * Update feed status active
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function activate(Request $request)
    {
        $dataOwner = $this->feed->checkDataOwner(
            $request->userId,
            $request->input()['feedId']
        );
        if (!$dataOwner['status']) {
            return response()->json([
                'success' => $dataOwner['status'],
                'message' => $dataOwner['message'],
            ])->setStatusCode(config('constants.status_codes.bad_request'));
        }
        
        $data = $this->feed->updateFeed(
            [['user_id', '=', $request->userId], ['id', '=', $request->input()['feedId']]],
            ['status' => config('constants.status.active')]
        );
        if (!$data['status']) {
            return response()->json([
                'success' => $data['status'],
                'message' => $data['message'],
            ])->setStatusCode(config('constants.status_codes.bad_request'));
        }
        
        return response()->json([
            'success' => $data['status'],
            'message' => 'Feeds successfully activated.'
        ])->setStatusCode(config('constants.status_codes.success'));
    }
    
    /**
     * Edit user feed and set status passive
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function edit(Request $request)
    {
        $dataOwner = $this->feed->checkDataOwner(
            $request->userId,
            $request->input()['feedId']
        );
        if (!$dataOwner['status']) {
            return response()->json([
                'success' => $dataOwner['status'],
                'message' => $dataOwner['message'],
            ])->setStatusCode(config('constants.status_codes.bad_request'));
        }
        
        $data = $this->feed->updateFeed(
            [['user_id', '=', $request->userId], ['id', '=', $request->input()['feedId']]],
            ['status' => config('constants.status.passive')]
        );
        if (!$data['status']) {
            return response()->json([
                'success' => $data['status'],
                'message' => $data['message'],
            ])->setStatusCode(config('constants.status_codes.bad_request'));
        }
        
        $data = $this->feed->updateFeed(
            [['user_id', '=', $request->userId], ['id', '=', $request->input()['feedId']]],
            ['data' => $request->input()['value']]
        );
        if (!$data['status']) {
            return response()->json([
                'success' => $data['status'],
                'message' => $data['message'],
            ])->setStatusCode(config('constants.status_codes.bad_request'));
        }
        
        return response()->json([
            'success' => $data['status'],
            'message' => 'Feed successfully edited.'
        ])->setStatusCode(config('constants.status_codes.success'));
    }
    
    /**
     * Get feed all published and all user
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function getFlow()
    {
        $feedsData = $this->feed->getFlow();
        if (!$feedsData['status']) {
            return response()->json([
                'success' => $feedsData['status'],
                'message' => $feedsData['message'],
            ])->setStatusCode(config('constants.status_codes.bad_request'));
        }
        
        return response()->json([
            'success' => $feedsData['status'],
            'message' => 'Feeds successfully listed.',
            'data' => $feedsData['data'],
        ])->setStatusCode(config('constants.status_codes.success'));
    }
    
    /**
     * Get any user data
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function getOtherUser(Request $request)
    {
        $data = $this->feed->getFeed(
            [
                ['user_name', '=', $request->input()['username']],
                ['status', '=', config('constants.status.active')]
            ],
            ['user_name', 'data']
        );
        if (!$data['status']) {
            return response()->json([
                'success' => $data['status'],
                'message' => $data['message'],
            ])->setStatusCode(config('constants.status_codes.bad_request'));
        }
        
        return response()->json([
            'success' => $data['status'],
            'message' => 'Feeds successfully listed.',
            'data' => $data['data'],
        ])->setStatusCode(config('constants.status_codes.success'));
    }
    
    /**
     * Get feed from source
     *
     * @param IFeeder $feeder
     * @param array $data
     *
     * @return mixed
     */
    public function getFeedSource(IFeeder $feeder, array $data)
    {
        $feeds = $feeder->getFeeds($data);
        $user = new User();
        if (!empty($data['email'])) {
            $userData = $user->getData(
                [['email', '=', $data['email']]],
                ['id', 'user_name', 'feeder_platform']
            );
            if (!$userData['status']) {
                return $userData;
            }
        } else {
            $userData = $user->getData(
                [['user_name', '=', $data['userName']]],
                ['id', 'user_name', 'feeder_platform']
            );
            if (!$userData['status']) {
                return $userData;
            }
        }
        
        $data = [];
        foreach ($feeds['data'] as $key => $val) {
            $data[] = [
                'user_id' => $userData['data']['id'],
                'user_name' => $userData['data']['user_name'],
                'user_feeder_platform' => $userData['data']['feeder_platform'],
                'data' => $val['string'],
                'status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        
        return $this->feed->insertSource($data);
    }
}