<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 12:30 PM
 */

namespace Application\Controller;


use Application\Controller\Helper\GetAccessToken;
use Model\Entity\ResponseBootstrap;
use Model\Service\RecepiesService;
use Symfony\Component\HttpFoundation\Request;

class RecepiesController
{

    private $recepiesService;

    public function __construct(RecepiesService $recepiesService)
    {
        $this->recepiesService = $recepiesService;
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

        // create response object
        $response = new ResponseBootstrap();

        // check data and call service
        if(isset($token) && isset($id) && isset($lang) && isset($state)){
            return $this->recepiesService->getRecepie($token, $id, $lang, $state);
        }else if(isset($token) && isset($ids) && isset($lang) && isset($state)){
            return $this->recepiesService->getRecepiesByIds($token, $ids, $lang, $state);
        }else if (isset($token) && isset($lang) && isset($state)){
            return $this->recepiesService->getRecepies($token, $lang, $app, $like, $state);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }


    /**
     * Get list of recepies
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
            return $this->recepiesService->getList($from, $limit, $token, $state, $lang);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        // return data
        return $response;
    }


    /**
     * Delete recepie
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
        if(isset($token) && isset($id)){
            return $this->recepiesService->deleteRecepie($token, $id);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }


    /**
     * Edit recepie
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
        $recepies = isset($data['recepies']) ? $data['recepies'] : null;
        $behavior = isset($data['behavior']) ? $data['behavior'] : null;

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data
        if(isset($token) && isset($id) && isset($names) && isset($recepies) && isset($tags) && isset($thumbnail) && isset($behavior)){
            return $this->recepiesService->editRecepie($token, $id, $names, $recepies, $tags, $thumbnail, $behavior);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }
    }


    /**
     * Add or release recepie
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
        $recepies = isset($data['recepies']) ? $data['recepies'] : null;
        $behavior = isset($data['behavior']) ? $data['behavior'] : null;

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data
        if(isset($token) && isset($names) && isset($recepies) && isset($tags) && isset($thumbnail) && isset($behavior)){
            return $this->recepiesService->createRecepie($token, $names, $recepies, $tags, $thumbnail, $behavior);
        }else if(isset($token) && isset($id)){
            return $this->recepiesService->releaseRecepie($token, $id);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }
}