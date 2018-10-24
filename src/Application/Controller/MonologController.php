<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 9:19 AM
 */

namespace Application\Controller;


use Application\Controller\Helper\GetAccessToken;
use Model\Entity\ResponseBootstrap;
use Model\Service\MonologService;
use Symfony\Component\HttpFoundation\Request;

class MonologController
{

    private $monologService;


    public function __construct(MonologService $monologService)
    {
        $this->monologService = $monologService;
    }


    /**
     * Get monolog logs
     *
     * @param Request $request
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getLogs(Request $request):ResponseBootstrap {
        // get data from url
        $type = $request->get('type');
        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check token
        if(isset($token) && isset($type)){
            return $this->monologService->getLogs($token, $type);
        }else {
            $response->setStatus(401);
            $response->setMessage('Bad credentials');
        }

        return $response;
    }


    /**
     * Delete monolog log
     *
     * @param Request $request
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteLog(Request $request):ResponseBootstrap {
        // get url parametars
        $type = $request->get('type');
        $date = $request->get('date');

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data and call service
        if(isset($date) && isset($type) && isset($token)){
            return $this->monologService->deleteLog($token, $date, $type);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }


    /**
     * Send email data
     *
     * @param Request $request
     * @return ResponseBootstrap
     */
    public function postEmail(Request $request){
        // get data from request body
        $data = json_decode($request->getContent(), true);
        $to = $data['to'];
        $title = $data['title'];
        $body = $data['body'];

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data and call service
        if(isset($to) && isset($title) && isset($body) && isset($token)){
            return $this->monologService->notifyDeveloper($to, $title, $body, $token);
        }else {
            $response->setStatus(200);
            $response->setMessage('Bad request');
        }

        return $response;
    }
}