<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 11:28 AM
 */

namespace Model\Service;


use Component\LinksConfiguration;
use Model\Core\Helper\Monolog\MonologSender;
use Model\Entity\ResponseBootstrap;
use Model\Mapper\NutritionPlansMapper;
use Model\Service\Helper\AuthHelper;

class NutritionPlansService extends LinksConfiguration
{

    private $nutritionPlansMapper;
    private $configuration;
    private $monologHelper;

    public function __construct(NutritionPlansMapper $nutritionPlansMapper)
    {
        $this->nutritionPlansMapper = $nutritionPlansMapper;
        $this->configuration = $nutritionPlansMapper->getConfiguration();
        $this->monologHelper = new MonologSender();
    }


    /**
     * Get plan by id
     *
     * @param int $id
     * @param string $lang
     * @param string $state
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPlan(string $token, int $id, string $lang, string $state):ResponseBootstrap{

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
                $res = $client->request('GET', $this->configuration['nutritionplans_url'] . '/nutritionplans?id=' .$id . '&lang=' . $lang . '&state=' . $state, []);

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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Get nutrition plan service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Get list of nutrition plans
     *
     * @param int $from
     * @param int $limit
     * @param string $token
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getList(int $from, int $limit, string $state = null, string $token, string $lang = null):ResponseBootstrap{

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
                $res = $client->request('GET', $this->configuration['nutritionplans_url'] . '/nutritionplans/list?from=' . $from . '&limit=' . $limit . '&state=' . $state . '&lang=' .$lang, []);

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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Get nutritionplans list service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Get plans
     *
     * @param string $lang
     * @param string|null $app
     * @param string|null $like
     * @param string $state
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPlans(string $token, string $lang, string $app = null, string $like = null, string $state):ResponseBootstrap{

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
                $res = $client->request('GET', $this->configuration['nutritionplans_url'] . '/nutritionplans/plans?lang=' .$lang . '&app=' . $app . '&like=' . $like . '&state=' . $state, []);

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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Get nutrition plans service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Get plans by ids
     *
     * @param array $ids
     * @param string $lang
     * @param string $state
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPlansByIds(string $token, string $ids, string $lang, string $state):ResponseBootstrap{

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
                $res = $client->request('GET', $this->configuration['nutritionplans_url'] . '/nutritionplans/ids?lang=' .$lang. '&state=' .$state. '&ids=' . $ids , []);

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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Get nutrition plans by ids service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Delete plan by id
     *
     * @param int $id
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deletePlan(string $token, int $id):ResponseBootstrap{

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
                $res = $client->request('DELETE', $this->configuration['nutritionplans_url'] . '/nutritionplans?id=' . $id, []);

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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Delete nutrition plan service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Edit nutrition plan
     *
     * @param int $id
     * @param string $rawName
     * @param string $type
     * @param array $names
     * @param array $recepies
     * @param array $tags
     * @param string $thumbnail
     * @return ResponseBootstrap
     */
    public function editPlan(string $token, int $id, string $rawName, string $type, array $names, array $recepies, array $tags, string $thumbnail):ResponseBootstrap {

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
                $res = $client->put($this->configuration['nutritionplans_url'] . '/nutritionplans',
                    [
                        \GuzzleHttp\RequestOptions::JSON => [
                            'id' => $id,
                            'names' => $names,
                            'recepies' => $recepies,
                            'tags' => $tags,
                            'thumbnail' => $thumbnail,
                            'raw_name' => $rawName,
                            'type' => $type
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Edit nutrition plan service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Create plan
     *
     * @param string $rawName
     * @param string $type
     * @param array $names
     * @param array $recepies
     * @param array $tags
     * @param string $thumbnail
     * @return ResponseBootstrap
     */
    public function createPlan(string $token, string $rawName, string $type, array $names, array $recepies, array $tags, string $thumbnail):ResponseBootstrap{

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
                $res = $client->post($this->configuration['nutritionplans_url'] . '/nutritionplans',
                    [
                        \GuzzleHttp\RequestOptions::JSON => [
                            'names' => $names,
                            'recepies' => $recepies,
                            'tags' => $tags,
                            'thumbnail' => $thumbnail,
                            'raw_name' => $rawName,
                            'type' => $type
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Create nutrition plan service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Release plan
     *
     * @param int $id
     * @return ResponseBootstrap
     */
    public function releasePlan(string $token, int $id):ResponseBootstrap{

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
                $res = $client->post($this->configuration['nutritionplans_url'] . '/nutritionplans/release',
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Release nutrition plan service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }
}