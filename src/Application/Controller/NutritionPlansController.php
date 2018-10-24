<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 11:27 AM
 */

namespace Application\Controller;

use Application\Controller\Helper\GetAccessToken;
use Model\Entity\ResponseBootstrap;
use Model\Service\NutritionPlansService;
use Symfony\Component\HttpFoundation\Request;

class NutritionPlansController
{

    private $nutritionPlansService;

    public function __construct(NutritionPlansService $nutritionPlansService)
    {
        $this->nutritionPlansService = $nutritionPlansService;
    }


    /**
     * Get controller
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
        if(isset($id) && isset($lang) && isset($state) && isset($token)){
            return $this->nutritionPlansService->getPlan($token, $id, $lang, $state);
        }else if(isset($ids) && isset($lang) && isset($state) && isset($token)){
            return $this->nutritionPlansService->getPlansByIds($token, $ids, $lang, $state);
        }else {
            return $this->nutritionPlansService->getPlans($token, $lang, $app, $like, $state);
        }
    }


    /**
     * Get ist of nutrition plans
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
            return $this->nutritionPlansService->getList($from, $limit, $state, $token, $lang);
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
            return $this->nutritionPlansService->deletePlan($token, $id);
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
        $rawName = $data['raw_name'];
        $type = $data['type'];
        $thumbnail = isset($data['thumbnail']) ? $data['thumbnail'] : null;
        $recepies = isset($data['recepies']) ? $data['recepies'] : null;

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data
        if(isset($token) && isset($id) && isset($rawName) && isset($type) && isset($names) && isset($recepies) && isset($tags) && isset($thumbnail)){
            return $this->nutritionPlansService->editPlan($token, $id, $rawName, $type, $names, $recepies, $tags, $thumbnail);
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
        $rawName = $data['raw_name'];
        $type = $data['type'];
        $thumbnail = isset($data['thumbnail']) ? $data['thumbnail'] : null;
        $recepies = isset($data['recepies']) ? $data['recepies'] : null;

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data
        if(isset($token) && isset($rawName) && isset($type) && isset($names) && isset($recepies) && isset($tags) && isset($thumbnail)){
            return $this->nutritionPlansService->createPlan($token, $rawName, $type, $names, $recepies, $tags, $thumbnail);
        }else if(isset($token) && isset($id)){
            return $this->nutritionPlansService->releasePlan($token, $id);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }
}