<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 10:53 AM
 */

namespace Model\Service;


use Component\LinksConfiguration;
use Model\Core\Helper\Monolog\MonologSender;
use Model\Entity\ResponseBootstrap;
use Model\Mapper\PackagesMapper;
use Model\Service\Helper\AuthHelper;

class PackagesService extends LinksConfiguration
{

    private $packagesMapper;
    private $configuration;
    private $monologHelper;

    public function __construct(PackagesMapper $packagesMapper)
    {
        $this->packagesMapper = $packagesMapper;
        $this->configuration = $packagesMapper->getConfiguration();
        $this->monologHelper = new MonologSender();
    }


    /**
     * Get package by id
     *
     * @param int $id
     * @param string $lang
     * @param string $state
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPackage(string $token, int $id, string $lang, string $state):ResponseBootstrap{

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
                $res = $client->request('GET', $this->configuration['packages_url'] . '/packages?id=' .$id . '&lang=' . $lang . '&state=' . $state, []);

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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Get package service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Get list of packages
     *
     * @param int $from
     * @param int $limit
     * @param string $token
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getList(int $from, int $limit, string $state = null, string $token):ResponseBootstrap{

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
                $res = $client->request('GET', $this->configuration['packages_url'] . '/packages/list?from=' . $from . '&limit=' . $limit . '&state=' . $state, []);

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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Get packages list service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Get packages
     *
     * @param string $lang
     * @param string $state
     * @param string|null $like
     * @param string|null $app
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPackages(string $token, string $lang, string $state, string $like = null, string $app = null):ResponseBootstrap{

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
                $res = $client->request('GET', $this->configuration['packages_url'] . '/packages/packages?lang=' . $lang . '&state=' . $state . '&like=' . $like . '&app=' . $app, []);

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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Get packages service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Get packages by ids
     *
     * @param array $ids
     * @param string $lang
     * @param string $state
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPackagesByIds(string $token, string $ids, string $lang, string $state):ResponseBootstrap{

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
                $res = $client->request('GET', $this->configuration['packages_url'] . '/packages/ids?lang=' . $lang . '&state=' . $state . '&ids=' . $ids, []);  // ??????

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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Get packages by ids service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Edit package
     *
     * @param int $id
     * @param array $names
     * @param $plans
     * @param array $tags
     * @param string $thumbnail
     * @param string $rawName
     * @return ResponseBootstrap
     */
    public function editPackage(string $token, int $id, array $names, $plans, array $tags, string $thumbnail, string $rawName):ResponseBootstrap {

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
                $res = $client->put($this->configuration['packages_url'] . '/packages',
                    [
                        \GuzzleHttp\RequestOptions::JSON => [
                            'id' => $id,
                            'names' => $names,
                            'plans' => $plans,
                            'tags' => $tags,
                            'thumbnail' => $thumbnail,
                            'raw_name' => $rawName
                        ]
                    ]);

                // set data to variable
                $res = $res->getStatusCode();

                // set response
                if($res == 200){
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Edit package service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Delete package by id
     *
     * @param int $id
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deletePackage(string $token, int $id):ResponseBootstrap{

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
                $res = $client->request('DELETE', $this->configuration['packages_url'] . '/packages?id=' . $id, []);

                // set data to variable
                $res = $res->getStatusCode();

                // set response
                if($res == 200){
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Delete package service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Create package
     *
     * @param array $names
     * @param $plans
     * @param array $tags
     * @param string $thumbnail
     * @param string $rawName
     * @return ResponseBootstrap
     */
    public function createPackage(string $token, array $names, $plans, array $tags, string $thumbnail, string $rawName):ResponseBootstrap {

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
                $res = $client->post($this->configuration['packages_url'] . '/packages',
                    [
                        \GuzzleHttp\RequestOptions::JSON => [
                            'names' => $names,
                            'plans' => $plans,
                            'tags' => $tags,
                            'thumbnail' => $thumbnail,
                            'raw_name' => $rawName
                        ]
                    ]);

                // set data to variable
                $res = $res->getStatusCode();

                // set response
                if($res == 200){
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Create package service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }

    }


    /**
     * Release package
     *
     * @param int $id
     * @return ResponseBootstrap
     */
    public function releasePackage(string $token, int $id):ResponseBootstrap{

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
                $res = $client->post($this->configuration['packages_url'] . '/packages/release',
                    [
                        \GuzzleHttp\RequestOptions::JSON => [
                            'id' => $id
                        ]
                    ]);

                // set data to variable
                $res = $res->getStatusCode();

                // set response
                if($res == 200){
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Release package service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }
}