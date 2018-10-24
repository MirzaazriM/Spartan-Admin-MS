<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 1:37 PM
 */

namespace Application\Controller;


use Application\Controller\Helper\GetAccessToken;
use Model\Entity\ResponseBootstrap;
use Model\Service\LoginService;
use Symfony\Component\HttpFoundation\Request;

class LoginController
{

    private $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function get(Request $request):ResponseBootstrap {
        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

    }

    public function post(Request $request):ResponseBootstrap {
        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);
    }


}