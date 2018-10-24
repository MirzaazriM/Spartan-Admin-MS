<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 12:46 PM
 */

namespace Application\Controller;


use Application\Controller\Helper\GetAccessToken;
use Model\Entity\ResponseBootstrap;
use Model\Service\UsersService;
use Symfony\Component\HttpFoundation\Request;

class UsersController
{

    private $usersService;

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }


    /**
     * Get user
     *
     * @param Request $request
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(Request $request):ResponseBootstrap {
        // get url parametars
        $id = $request->get('id');
        $app = $request->get('app');
        $like = $request->get('like');

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data and call service
        if(isset($token) && isset($id)){
            return $this->usersService->getUser($token, $id);
        }else if(isset($token) && isset($app) or isset($like)) {
            return $this->usersService->getUsers($token, $app, $like);
        }else {
            return $this->usersService->getUsers($token, $app, $like);
        }
    }


    /**
     * Edit user
     *
     * @param Request $request
     * @return ResponseBootstrap
     */
    public function put(Request $request):ResponseBootstrap {
        // get data
        $data = json_decode($request->getContent(), true);
        $id = $data['id'];
        $name = $data['name'];
        $surname = $data['surname'];
        $email = $data['email'];
        $location = $data['location'];

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object in case of failure
        $response = new ResponseBootstrap();

        if(isset($token) && isset($id) && isset($name) && isset($surname) && isset($email) && isset($location)){
            return $this->usersService->editUser($token, $id, $name, $surname, $email, $location);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }


    /**
     * Add user
     *
     * @param Request $request
     * @return ResponseBootstrap
     */
    public function post(Request $request):ResponseBootstrap {
        // get data
        $data = json_decode($request->getContent(), true);
        $name = $data['name'];
        $surname = $data['surname'];
        $email = $data['email'];
        $location = $data['location'];

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object in case of failure
        $response = new ResponseBootstrap();

        if(isset($token) && isset($name) && isset($surname) && isset($email) && isset($location)){
            return $this->usersService->addUser($token, $name, $surname, $email, $location);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }

}