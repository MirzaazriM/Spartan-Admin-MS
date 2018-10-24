<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 11:51 AM
 */

namespace Application\Controller;


use Application\Controller\Helper\GetAccessToken;
use Model\Entity\ResponseBootstrap;
use Model\Service\ExercisesService;
use Symfony\Component\HttpFoundation\Request;

class ExercisesController
{

    private $exercisesService;

    public function __construct(ExercisesService $exercisesService)
    {
        $this->exercisesService = $exercisesService;
    }


    /**
     * Get exercise/s
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
            return $this->exercisesService->getExercise($token, $id, $lang, $state);
        }else if(isset($ids) && isset($lang) && isset($state) && isset($token)){
            return $this->exercisesService->getExercisesByIds($token, $ids, $lang, $state);
        }else {
            return $this->exercisesService->getExercises($token, $lang, $state, $app, $like);
        }
    }


    /**
     * Get list of exercises
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

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data and call service
        if(isset($from) && isset($limit) && isset($token)){ //  && isset($state)
            return $this->exercisesService->getList($from, $limit, $token, $state);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        // return data
        return $response;
    }


    /**
     * Delete exercise
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
            return $this->exercisesService->deleteExercise($token, $id);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }


    /**
     * Edit exercise
     *
     * @param Request $request
     * @return ResponseBootstrap
     */
    public function put(Request $request):ResponseBootstrap {
        // get body data
        $data = json_decode($request->getContent(), true);
        $id = isset($data['id']) ? $data['id'] : null;
        $hardness = isset($data['hardness']) ? $data['hardness'] : null;
        $muscles = isset($data['muscles_involved']) ? $data['muscles_involved'] : null;
        $thumbnail = isset($data['thumbnail']) ? $data['thumbnail'] : null;
        $rawName = isset($data['raw_name']) ? $data['raw_name'] : null;
        $names = isset($data['names']) ? $data['names'] : null;
        $tags = isset($data['tags']) ? $data['tags'] : null;
        $medias = isset($data['media']) ? $data['media'] : null;

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data
        if(isset($token) && isset($id) && isset($hardness) && isset($thumbnail) && isset($muscles) && isset($rawName) && isset($names) && isset($medias) && isset($tags)){
            return $this->exercisesService->editExercise($token, $id, $hardness, $muscles, $thumbnail, $rawName, $names, $medias, $tags);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }


    /**
     * Add or release exercise
     *
     * @param Request $request
     * @return ResponseBootstrap
     */
    public function post(Request $request):ResponseBootstrap {
        // get body data
        $data = json_decode($request->getContent(), true);
        $id = isset($data['id']) ? $data['id'] : null;
        $hardness = isset($data['hardness']) ? $data['hardness'] : null;
        $muscles = isset($data['muscles_involved']) ? $data['muscles_involved'] : null;
        $thumbnail = isset($data['thumbnail']) ? $data['thumbnail'] : null;
        $rawName = isset($data['raw_name']) ? $data['raw_name'] : null;
        $names = isset($data['names']) ? $data['names'] : null;
        $tags = isset($data['tags']) ? $data['tags'] : null;
        $medias = isset($data['media']) ? $data['media'] : null;

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data
        if(isset($token) && isset($hardness) && isset($thumbnail) && isset($muscles) && isset($rawName) && isset($names) && isset($medias) && isset($tags)){
            return $this->exercisesService->createExercise($token, $hardness, $muscles, $thumbnail, $rawName, $names, $medias, $tags);
        }else if(isset($id) && isset($token)){
            return $this->exercisesService->releaseExercise($token, $id);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }

}