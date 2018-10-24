<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 12:21 PM
 */

namespace Application\Controller;


use Application\Controller\Helper\GetAccessToken;
use Model\Entity\ResponseBootstrap;
use Model\Service\TagsService;
use Symfony\Component\HttpFoundation\Request;

class TagsController
{

    private $tagsService;

    public function __construct(TagsService $tagsService)
    {
        $this->tagsService = $tagsService;
    }


    /**
     * Get tag/s
     *
     * @param Request $request
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(Request $request):ResponseBootstrap {
        // get url parametars
        $id = $request->get('id');
        $ids = $request->get('ids');
        $lang = $request->get('lang') ;
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
            return $this->tagsService->getTag($token, $id, $lang, $state);
        }else if(isset($token) && isset($ids) && isset($lang) && isset($state)){
            return $this->tagsService->getTagsByIds($token, $ids, $lang, $state);
        }else if (isset($token) && isset($lang)){ //  && isset($state)
            return $this->tagsService->getTags($token, $lang, $app, $like, $state);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }


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
            return $this->tagsService->getList($from, $limit, $token, $state, $lang);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        // return data
        return $response;
    }



    /**
     * Delete tag
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
            return $this->tagsService->deleteTag($token, $id);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }


    /**
     * Edit tag
     *
     * @param Request $request
     * @return ResponseBootstrap
     */
    public function put(Request $request):ResponseBootstrap {
        // get body data
        $data = json_decode($request->getContent(), true);
        $id = $data['id'];
        $names = $data['names'];
        $behavior = isset($data['behavior']) ? $data['behavior'] : null;

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data
        if(isset($token) && isset($id) && isset($names) && isset($behavior)){
            return $this->tagsService->editTag($token, $id, $names, $behavior);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;

    }


    /**
     * Add or release tag
     *
     * @param Request $request
     * @return ResponseBootstrap
     */
    public function post(Request $request):ResponseBootstrap {
        // get body data
        $data = json_decode($request->getContent(), true);
        $id = isset($data['id']) ? $data['id'] : null;
        $names = isset($data['names']) ? $data['names'] : null;
        $behavior = isset($data['behavior']) ? $data['behavior'] : null;

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data
        if(isset($token) && isset($names) && isset($behavior)){
            return $this->tagsService->createTag($token, $names, $behavior);
        }else if(isset($token) && isset($id)){
            return $this->tagsService->releaseTag($token, $id);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }

}