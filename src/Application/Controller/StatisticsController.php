<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 8:31 AM
 */

namespace Application\Controller;


use Application\Controller\Helper\GetAccessToken;
use Model\Entity\ResponseBootstrap;
use Model\Service\StatisticsService;
use Symfony\Component\HttpFoundation\Request;

class StatisticsController
{

    private $statisticsService;

    public function __construct(StatisticsService $statisticsService){
        $this->statisticsService = $statisticsService;
    }

    public function get(Request $request):ResponseBootstrap {
        // get access token
        $getToken = new GetAccessToken();
        $token = $getToken->accessToken($request);

        // create response object
        $response = new ResponseBootstrap();

        // check token
        if(isset($token)){
            return $this->statisticsService->getStatistics($token);
        }else {
            $response->setStatus(401);
            $response->setMessage('Bad credentials');
        }

        return $response;
    }
}