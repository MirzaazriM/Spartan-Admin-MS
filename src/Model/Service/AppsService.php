<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 10:36 AM
 */

namespace Model\Service;


use Component\LinksConfiguration;
use Model\Core\Helper\Monolog\MonologSender;
use Model\Entity\ResponseBootstrap;
use Model\Mapper\AppsMapper;
use Model\Service\Helper\AuthHelper;
use Symfony\Component\Config\Definition\Exception\Exception;

class AppsService extends LinksConfiguration
{

    private $appsMapper;
    private $configuration;
    private $monologHelper;

    public function __construct(AppsMapper $appsMapper)
    {
        $this->appsMapper = $appsMapper;
        $this->configuration = $appsMapper->getConfiguration();
        $this->monologHelper = new MonologSender();
    }


    /**
     * Get specified app
     *
     * @param int $id
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getApp(string $token, int $id):ResponseBootstrap {

        try {
            // create response object
            $response = new ResponseBootstrap();

            // check authorization
//        $authController = new AuthHelper($token, $scope = 'all', $this->configuration);
//        $allowed = $authController->checkAuthorization();
            $allowed = 200; // DEMO

            if($allowed == 200){
                // create guzzle client and call MS for data
                $client = new \GuzzleHttp\Client();
                $res = $client->request('GET', $this->configuration['apps_url'] . '/apps?id=' . $id, []);

                // set data to variable
                $data = $res->getBody()->getContents();

                // set response
                if(!empty($data)){
                    $response->setStatus(200);
                    $response->setMessage('Success');
                    $response->setData([
                        'data' => json_decode($data)
                    ]);
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Get app service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Get all apps
     *
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getApps(string $token):ResponseBootstrap {

        try {
            // create response object
            $response = new ResponseBootstrap();

            // check authorization
//        $authController = new AuthHelper($token, $scope = 'all', $this->configuration);
//        $allowed = $authController->checkAuthorization();
            $allowed = 200; // DEMO

            if($allowed == 200){
                // create guzzle client and call MS for data
                $client = new \GuzzleHttp\Client();
                $res = $client->request('GET', $this->configuration['apps_url'] . '/apps', []);

                // set data to variable
                $data = $res->getBody()->getContents();

                // set response
                if(!empty($data)){
                    $response->setStatus(200);
                    $response->setMessage('Success');
                    $response->setData([
                        'data' => json_decode($data)
                    ]);
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Get apps service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Add new app
     *
     * @param string $name
     * @param array $collection
     * @return ResponseBootstrap
     */
    public function addApp(string $token, string $name, string $identifier, array $collection):ResponseBootstrap {

        try {
            // create response object
            $response = new ResponseBootstrap();

            // check authorization
//        $authController = new AuthHelper($token, $scope = 'all', $this->configuration);
//        $allowed = $authController->checkAuthorization();
            $allowed = 200; // DEMO

            if($allowed == 200){
                // create guzzle client and send it data
                $client = new \GuzzleHttp\Client();
                $res = $client->post($this->configuration['apps_url'] . '/apps',
                    [
                        \GuzzleHttp\RequestOptions::JSON => [
                            'name' => $name,
                            'identifier' => $identifier,
                            'collection' => $collection
                        ]
                    ]);

                // get status
                $code = $res->getStatusCode();

                // set response
                if($code == 200){
                    $response->setStatus(200);
                    $response->setMessage('Success');
                }else {
                    $response->setStatus(304);
                    $response->setMessage('Not modified');
                }
            }else {
                $response->setStatus(401);
                $response->setMessage('Bad credentials');
            }

            // return response
            return $response;

        }catch (\Exception $e){
            // send monolog record
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Add app service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Edit specified app
     *
     * @param int $id
     * @param string $name
     * @param array $collection
     * @return ResponseBootstrap
     */
    public function editApp(string $token, int $id, string $name, string $identifier, array $collection):ResponseBootstrap {

        try {
            // create response object
            $response = new ResponseBootstrap();

            // check authorization
//        $authController = new AuthHelper($token, $scope = 'all', $this->configuration);
//        $allowed = $authController->checkAuthorization();
            $allowed = 200; // DEMO

            if($allowed == 200){
                // create guzzle client and send it data
                $client = new \GuzzleHttp\Client();
                $res = $client->put($this->configuration['apps_url'] . '/apps',
                    [
                        \GuzzleHttp\RequestOptions::JSON => [
                            'id' => $id,
                            'name' => $name,
                            'identifier' => $identifier,
                            'collection' => $collection
                        ]
                    ]);

                // get code
                $code = $res->getStatusCode();

                // set response
                if($code == 200){
                    $response->setStatus(200);
                    $response->setMessage('Success');
                }else {
                    $response->setStatus(304);
                    $response->setMessage('Not modified');
                }
            }else {
                $response->setStatus(401);
                $response->setMessage('Bad credentials');
            }

            // return response
            return $response;

        }catch (Exception $e){
            // send monolog record
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Edit app service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Delete specified app
     *
     * @param int $id
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteApp(string $token, int $id):ResponseBootstrap {

        try {
            // create response object
            $response = new ResponseBootstrap();

            // check authorization
//        $authController = new AuthHelper($token, $scope = 'all', $this->configuration);
//        $allowed = $authController->checkAuthorization();
            $allowed = 200; // DEMO

            if($allowed == 200){
                // create guzzle client and call MS for data
                $client = new \GuzzleHttp\Client();
                $res = $client->request('DELETE', $this->configuration['apps_url'] . '/apps?id=' . $id, []);

                // get code
                $code = $res->getStatusCode();

                // set response
                if($code == 200){
                    $response->setStatus(200);
                    $response->setMessage('Success');
                }else {
                    $response->setStatus(304);
                    $response->setMessage('Not modified');
                }
            }else {
                $response->setStatus(401);
                $response->setMessage('Bad credentials');
            }

            // return response
            return $response;

        }catch (\Exception $e){
            // send monolog record
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Delete app service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }
}