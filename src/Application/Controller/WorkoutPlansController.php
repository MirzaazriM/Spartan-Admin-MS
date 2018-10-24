<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 11:08 AM
 */

namespace Application\Controller;


use Application\Controller\Helper\GetAccessToken;
use Model\Entity\ResponseBootstrap;
use Model\Service\WorkoutPlansService;
use Symfony\Component\HttpFoundation\Request;

class WorkoutPlansController
{

    private $workoutPlansService;

    public function __construct(WorkoutPlansService $workoutPlansService)
    {
        $this->workoutPlansService = $workoutPlansService;
    }


    /**
     * Get workout plans
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
            return $this->workoutPlansService->getPlan($token, $id, $lang, $state);
        }else if(isset($token) && isset($ids) && isset($lang) && isset($state)){
            return $this->workoutPlansService->getPlansByIds($token, $ids, $lang, $state);
        }else {
            return $this->workoutPlansService->getPlans($token, $lang, $app, $like, $state);
        }
    }


    /**
     * Get list of workout plans
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
        if(isset($from) && isset($limit) && isset($token)){ // && isset($state)
            return $this->workoutPlansService->getList($from, $limit, $state, $token, $lang);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        // return data
        return $response;
    }


    /**
     * Delete plan
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
            return $this->workoutPlansService->deletePlan($token, $id);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }


    /**
     * Edit workout plan
     *
     * @param Request $request
     * @return ResponseBootstrap
     */
    public function put(Request $request):ResponseBootstrap {
        // get body data
        $data = json_decode($request->getContent(), true);
        $id = isset($data['id']) ? $data['id'] : null;
        $names = isset($data['names']) ? $data['names'] : null;
        $tags = isset($data['tags']) ? $data['tags'] : null;
        $thumbnail = isset($data['thumbnail']) ? $data['thumbnail'] : null;
        $rawName = isset($data['raw_name']) ? $data['raw_name'] : null;
        $type = isset($data['type']) ? $data['type'] : null;
        $workouts = isset($data['workouts']) ? $data['workouts'] : null;

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data
        if(isset($token) && isset($rawName) && isset($type) && isset($id) && isset($names) && isset($workouts) && isset($tags) && isset($thumbnail)){
            return $this->workoutPlansService->editPlan($token, $rawName, $type, $id, $names, $workouts, $tags, $thumbnail);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }
        return $response;
    }


    /**
     * Add or release plan
     *
     * @param Request $request
     * @return ResponseBootstrap
     */
    public function post(Request $request):ResponseBootstrap {
        // get body data
        $data = json_decode($request->getContent(), true);
        $id = isset($data['id']) ? $data['id'] : null;
        $names = isset($data['names']) ? $data['names'] : null;
        $tags = isset($data['tags']) ? $data['tags'] : null;
        $thumbnail = isset($data['thumbnail']) ? $data['thumbnail'] : null;
        $rawName = isset($data['raw_name']) ? $data['raw_name'] : null;
        $type = isset($data['type']) ? $data['type'] : null;
        $workouts = isset($data['workouts']) ? $data['workouts'] : null;

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data
        if(isset($token) && isset($rawName) && isset($type) && isset($names) && isset($workouts) && isset($tags) && isset($thumbnail)){
            return $this->workoutPlansService->createPlan($token, $rawName, $type, $names, $workouts, $tags, $thumbnail);
        }else if(isset($token) && isset($id)){
            return $this->workoutPlansService->releasePlan($token, $id);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }

}