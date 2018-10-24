<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 10:53 AM
 */

namespace Application\Controller;


use Application\Controller\Helper\GetAccessToken;
use Model\Entity\ResponseBootstrap;
use Model\Service\PackagesService;
use Symfony\Component\HttpFoundation\Request;

class PackagesController
{

    private $packagesService;

    public function __construct(PackagesService $packagesService)
    {
        $this->packagesService = $packagesService;
    }


    /**
     * Get package/s
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
            return $this->packagesService->getPackage($token, $id, $lang, $state);
        }else if(isset($token) && isset($ids) && isset($lang) && isset($state)){
            return $this->packagesService->getPackagesByIds($token, $ids, $lang, $state);
        }else if(isset($token) && isset($lang) && isset($state)){
            return $this->packagesService->getPackages($token, $lang, $state, $like, $app);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;

    }


    /**
     * Get list of packages
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
            return $this->packagesService->getList($from, $limit, $state, $token);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        // return data
        return $response;
    }


    /**
     * Add or release package
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
        $plans = isset($data['plans']) ? $data['plans'] : null;

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data
        if(isset($token) && isset($names) && isset($plans) && isset($tags) && isset($thumbnail) && isset($rawName)){
            return $this->packagesService->createPackage($token, $names, $plans, $tags, $thumbnail, $rawName);
        }else if(isset($token) && isset($id)){
            return $this->packagesService->releasePackage($token, $id);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;

    }


    /**
     * Edit package
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
        $thumbnail = $data['thumbnail'];
        $rawName = $data['raw_name'];
        $plans = $data['plans'];

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data
        if(isset($token) && isset($id) && isset($names) && isset($plans) && isset($tags) && isset($thumbnail) && isset($rawName)){
            return $this->packagesService->editPackage($token, $id, $names, $plans, $tags, $thumbnail, $rawName);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }


    /**
     * Delete package
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
            return $this->packagesService->deletePackage($token, $id);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }
}