<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/26/18
 * Time: 9:34 PM
 */

namespace Application\Controller;


use Application\Controller\Helper\GetAccessToken;
use Model\Entity\ResponseBootstrap;
use Model\Service\PolicyService;
use Symfony\Component\HttpFoundation\Request;

class PolicyController
{

    private $policyService;

    public function __construct(PolicyService $policyService)
    {
        $this->policyService = $policyService;
    }


    /**
     * Get policy by id or all
     *
     * @param Request $request
     * @return ResponseBootstrap
     */
    public function get(Request $request):ResponseBootstrap {
        // get url parametars
        $id = $request->get('id');

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // check data and call service
        if(isset($id) && isset($token)){
            return $this->policyService->getPolicy($token, $id);
        }else {
            return $this->policyService->getPolicies($token);
        }

    }


    /**
     * Add policy
     *
     * @param Request $request
     * @return ResponseBootstrap
     */
    public function post(Request $request):ResponseBootstrap {
        // get data from request body
        $data = json_decode($request->getContent(), true);
        $title = $data['title'];
        $body = $data['body'];

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data and call service
        if(isset($title) && isset($body) && isset($token)){
            return $this->policyService->addPolicy($token, $title, $body);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }


    /**
     * Edit policy
     *
     * @param Request $request
     * @return ResponseBootstrap
     */
    public function put(Request $request):ResponseBootstrap {
        // get data from request body
        $data = json_decode($request->getContent(), true);
        $id = $data['id'];
        $title = $data['title'];
        $body = $data['body'];

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data and call service
        if(isset($token) && isset($id) && isset($title) && isset($body)){
            return $this->policyService->editPolicy($token, $id, $title, $body);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }


    /**
     * Delete policy
     *
     * @param Request $request
     * @return ResponseBootstrap
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
            return $this->policyService->deletePolicy($token, $id);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }
}