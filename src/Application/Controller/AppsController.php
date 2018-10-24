<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 10:35 AM
 */

namespace Application\Controller;


use Application\Controller\Helper\GetAccessToken;
use Model\Entity\ResponseBootstrap;
use Model\Service\AppsService;
use Symfony\Component\HttpFoundation\Request;

class AppsController
{

    private $appsService;

    public function __construct(AppsService $appsService)
    {
        $this->appsService = $appsService;
    }


    /**
     * Get app/s
     *
     * @param Request $request
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(Request $request):ResponseBootstrap {

        // get url parametars
        $id = $request->get('id');

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // check data and call service
        if(isset($id) && isset($token)){
            return $this->appsService->getApp($token, $id);
        }else {
            return $this->appsService->getApps($token);
        }
    }


    /**
     * Add app
     *
     * @param Request $request
     * @return ResponseBootstrap
     */
    public function post(Request $request):ResponseBootstrap {
        // get data from request body
        $data = json_decode($request->getContent(), true);
        $name = $data['name'];
        $identifier = $data['identifier'];
        $collection = $data['collection'];

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data and call service
        if(isset($name) && isset($identifier) && isset($collection) && isset($token)){
            return $this->appsService->addApp($token, $name, $identifier, $collection);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;

    }


    /**
     * Edit app
     *
     * @param Request $request
     * @return ResponseBootstrap
     */
    public function put(Request $request):ResponseBootstrap {
        // get data from request body
        $data = json_decode($request->getContent(), true);
        $id = $data['id'];
        $name = $data['name'];
        $identifier = $data['identifier'];
        $collection = $data['collection'];

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data and call service
        if(isset($id) && isset($name) && isset($identifier) && isset($collection) && isset($token)){
            return $this->appsService->editApp($token, $id, $name, $identifier, $collection);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }


    /**
     * Delete specified app
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
            return $this->appsService->deleteApp($token, $id);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }
}