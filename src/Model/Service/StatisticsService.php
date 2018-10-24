<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 8:32 AM
 */

namespace Model\Service;


use Model\Core\Helper\Monolog\MonologSender;
use Model\Core\StatisticsFacade;
use Model\Entity\ResponseBootstrap;
use Model\Mapper\StatisticsMapper;
use Model\Service\Helper\AuthHelper;

class StatisticsService
{

    private $statisticsMapper;
    private $configuration;
    private $monologHelper;

    public function __construct(StatisticsMapper $statisticsMapper)
    {
        $this->statisticsMapper = $statisticsMapper;
        $this->configuration = $this->statisticsMapper->getConfiguration();
        $this->monologHelper = new MonologSender();
    }


    public function getStatistics(string $token):ResponseBootstrap {

        try {
            // create response object
            $response = new ResponseBootstrap();

            // check authorization
//        $authController = new AuthHelper($token, $scope = 'all', $this->configuration);
//        $allowed = $authController->checkAuthorization();
            $allowed = 200; // DEMO

            if($allowed == 200){
                // create facade object
                $facade = new StatisticsFacade($this->statisticsMapper);

                // get and check data for setting appropriate response
                $data = $facade->getStatistics();

                if(!empty($data)){
                    $response->setStatus(200);
                    $response->setMessage('Success');
                    $response->setData(
                        $data
                    );
                }else {
                    $response->setStatus(204);
                    $response->setMessage('No content');
                }
            }else {
                $response->setStatus(401);
                $response->setMessage('Bad credentials');
            }

            // return response
            return $response;

        }catch (\Exception $e){
            // send monolog record
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Get statistic service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }
}