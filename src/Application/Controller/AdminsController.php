<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/26/18
 * Time: 6:13 PM
 */

namespace Application\Controller;


use Application\Controller\Helper\GetAccessToken;
use Model\Entity\ResponseBootstrap;
use Model\Service\AdminsService;
use Symfony\Component\HttpFoundation\Request;

class AdminsController
{
    private $adminsService;

    public function __construct(AdminsService $adminsService)
    {
        $this->adminsService = $adminsService;
    }


    /**
     * Get admin by id or all
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
            return $this->adminsService->getAdmin($token, $id);
        }else {
            return $this->adminsService->getAdmins($token);
        }
    }


    /**
     * Add new admin
     *
     * @param Request $request
     * @return ResponseBootstrap
     */
    public function post(Request $request):ResponseBootstrap {
        // get data from request body
        $data = json_decode($request->getContent(), true);
        $name = $data['name'];
        $surname = $data['surname'];
        $email = $data['email'];
        $scope = $data['scope'];

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data and call service
        if(isset($name) && isset($surname) && isset($email) && isset($scope)){
            return $this->adminsService->addAdmin($name, $surname, $email, $scope);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;

    }


    /**
     * Edit existing admin
     *
     * @param Request $request
     * @return ResponseBootstrap
     */
    public function put(Request $request):ResponseBootstrap {

        // get data from request body
        $data = json_decode($request->getContent(), true);
        $id = $data['id'];
        $name = $data['name'];
        $surname = $data['surname'];
        $email = $data['email'];
        $scope = $data['scope'];
        $state = $data['state'];

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data and call service
        if(isset($id) && isset($name) && isset($surname) && isset($email) && isset($scope) && isset($state)){
            return $this->adminsService->editAdmin($id, $name, $surname, $email, $scope, $state);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }


    /**
     * Delete admin
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
        if(isset($id)){
            return $this->adminsService->deleteAdmin($id);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;

    }

}