<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 1:00 PM
 */

namespace Application\Controller;


use Application\Controller\Helper\GetAccessToken;
use Model\Entity\ResponseBootstrap;
use Model\Service\PushService;
use Symfony\Component\HttpFoundation\Request;

class PushController
{

    private $pushService;

    public function __construct(PushService $pushService)
    {
        $this->pushService = $pushService;
    }


    /**
     * Get notification/s
     *
     * @param Request $request
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(Request $request):ResponseBootstrap {
        // get url parametars
        $id = $request->get('id');
        $type = $request->get('type');

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data and call service
        if(isset($token) && isset($id)){
            return $this->pushService->getPushNotification($token, $id);
        }else if(isset($token) && isset($type)) {
            return $this->pushService->getPushNotifications($token, $type);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }


    /**
     * Add notification
     *
     * @param Request $request
     * @return ResponseBootstrap
     */
    public function post(Request $request):ResponseBootstrap {
        // get data from request body
        $dat = json_decode($request->getContent(), true);
        $to = $dat['to'];
        // $message = $dat['message'];
        $data = $dat['data'];

        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check data and call service
        if(isset($token) && isset($to) && isset($data)){
            return $this->pushService->createPushNotification($token, $to, $data);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }


    /**
     * Delete notification
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
            return $this->pushService->deletePushNotification($token, $id);
        }else {
            $response->setStatus(404);
            $response->setMessage('Bad request');
        }

        return $response;
    }


}