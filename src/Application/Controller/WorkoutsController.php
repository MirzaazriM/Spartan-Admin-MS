<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 11:37 AM
 */

namespace Application\Controller;


use Application\Controller\Helper\GetAccessToken;
use Model\Entity\ResponseBootstrap;
use Model\Service\WorkoutsService;
use Symfony\Component\HttpFoundation\Request;

class WorkoutsController
{

    private $workoutsService;

    public function __construct(WorkoutsService $workoutsService)
    {
        $this->workoutsService = $workoutsService;
    }


    /**
     * Get workouts
     *
     * @param Request $request
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(Request $request):ResponseBootstrap {
        // get url parametars
        $id = $request->get('id');
        $ids = $request->get('ids');
        $lang = $request->get('lang');
        $app = $request->get('app');
        $like = $request->get('like');
        $state = $request->get('state');

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // check data and call service
        if(isset($token) && isset($id) && isset($lang) && isset($state)){
            return $this->workoutsService->getWorkout($token, $id, $lang, $state);
        }else if(isset($token) && isset($ids) && isset($lang) && isset($state)){
            return $this->workoutsService->getWorkoutsByIds($token, $ids, $lang, $state);
        }else {
            return $this->workoutsService->getWorkouts($token, $lang, $app, $like, $state);
        }
    }


    /**
     * Get workouts core list
     *
     * @param Request $request
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getList(Request $request):ResponseBootstrap {
        // get data
        $from = $request->get('from');
        $limit = $request->get('limit');
        $state = $request->get('state');
        $lang = $request->get('lang');

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data and call service
        if(isset($from) && isset($limit) && isset($token)){
            return $this->workoutsService->getList($from, $limit, $token, $state, $lang);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        // return data
        return $response;
    }


    /**
     * Delete workout
     *
     * @param Request $request
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(Request $request):ResponseBootstrap {
        // get url parametars
        $id = $request->get('id');

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data and call service
        if(isset($id) && isset($token)){
            return $this->workoutsService->deleteWorkout($token, $id);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }


    /**
     * Edit workout
     *
     * @param Request $request
     * @return ResponseBootstrap
     */
    public function put(Request $request):ResponseBootstrap {
        // get body data
        $data = json_decode($request->getContent(), true);
        $id = isset($data['id']) ? $data['id'] : null;
        $names = isset($data['names']) ? $data['names'] : null;
        $regularTags = isset($data['regular_tags']) ? $data['regular_tags'] : null;
        $equipmentTags = isset($data['equipment_tags']) ? $data['equipment_tags'] : null;
        $rounds = isset($data['rounds']) ? $data['rounds'] : null;
        $duration = isset($data['duration']) ? $data['duration'] : null;

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data
        if(isset($token) && isset($id) && isset($names) && isset($rounds) && isset($regularTags) && isset($equipmentTags) && isset($duration)){
            return $this->workoutsService->editWorkout($token, $id, $names, $rounds, $regularTags, $equipmentTags, $duration);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }


    /**
     * Add or release workout
     *
     * @param Request $request
     * @return ResponseBootstrap
     */
    public function post(Request $request):ResponseBootstrap {
        // get body data
        $data = json_decode($request->getContent(), true);
        $id = isset($data['id']) ? $data['id'] : null;
        $names = isset($data['names']) ? $data['names'] : null;
        $regularTags = isset($data['regular_tags']) ? $data['regular_tags'] : null;
        $equipmentTags = isset($data['equipment_tags']) ? $data['equipment_tags'] : null;
        $rounds = isset($data['rounds']) ? $data['rounds'] : null;
        $duration = isset($data['duration']) ? $data['duration'] : null;

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data
        if(isset($token) && isset($names) && isset($rounds) && isset($regularTags) && isset($equipmentTags) && isset($duration)){
            return $this->workoutsService->createWorkout($token, $names, $rounds, $regularTags, $equipmentTags, $duration);
        }else if(isset($token) && isset($id)){
            return $this->workoutsService->releaseWorkout($token, $id);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }

}