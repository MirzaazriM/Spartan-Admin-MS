<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 12:21 PM
 */

namespace Model\Service;

use Component\LinksConfiguration;
use Model\Core\Helper\Monolog\MonologSender;
use Model\Entity\ResponseBootstrap;
use Model\Mapper\TagsMapper;
use Model\Service\Helper\AuthHelper;

class TagsService extends LinksConfiguration
{

    private $tagsMapper;
    private $configuration;
    private $monologHelper;

    public function __construct(TagsMapper $tagsMapper)
    {
        $this->tagsMapper = $tagsMapper;
        $this->configuration = $tagsMapper->getConfiguration();
        $this->monologHelper = new MonologSender();
    }


    /**
     * Get tag by id
     *
     * @param int $id
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTag(string $token, int $id, string $lang, string $state):ResponseBootstrap {

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
                $res = $client->request('GET', $this->configuration['tags_url'] . '/tags?id=' .$id . '&lang=' . $lang . '&state=' . $state, []);

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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Get tag service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Get tags
     *
     * @param string $lang
     * @param string|null $app
     * @param string|null $like
     * @param string $state
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTags(string $token, string $lang, string $app = null, string $like = null, string $state = null):ResponseBootstrap {

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
                $res = $client->request('GET', $this->configuration['tags_url'] . '/tags/tags?lang=' .$lang . '&app=' . $app . '&like=' . $like . '&state=' . $state, []);
// die(print_r($res));
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Get tags service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    public function getList(int $from, int $limit, string $token, string $state = null, string $lang = null):ResponseBootstrap{

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
                $res = $client->request('GET', $this->configuration['tags_url'] . '/tags/list?from=' . $from . '&limit=' . $limit . '&state=' . $state . '&lang=' . $lang, []);

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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Get tags list service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }



    /**
     * Get tags by ids
     *
     * @param array $ids
     * @param string $lang
     * @param string $state
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTagsByIds(string $token, string $ids, string $lang, string $state):ResponseBootstrap{

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
                $res = $client->request('GET', $this->configuration['tags_url'] . '/tags/ids?lang=' .$lang . '&state=' .$state . '&ids=' . $ids, []);

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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Get tags by ids service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Delete tag by id
     *
     * @param int $id
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteTag(string $token, int $id):ResponseBootstrap{

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
                $res = $client->request('DELETE', $this->configuration['tags_url'] . '/tags?id=' . $id, []);

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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Delete tag service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Edit tag
     *
     * @param int $id
     * @param array $names
     * @param string $behavior
     * @return ResponseBootstrap
     */
    public function editTag(string $token, int $id, array $names, string $behavior):ResponseBootstrap{

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
                $res = $client->put($this->configuration['tags_url'] . '/tags',
                    [
                        \GuzzleHttp\RequestOptions::JSON => [
                            'id' => $id,
                            'names' => $names,
                            'behavior' => $behavior
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Edit tag service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Create tag
     *
     * @param array $names
     * @param string $behavior
     * @return ResponseBootstrap
     */
    public function createTag(string $token, array $names, string $behavior):ResponseBootstrap{

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
                $res = $client->post($this->configuration['tags_url'] . '/tags',
                    [
                        \GuzzleHttp\RequestOptions::JSON => [
                            'names' => $names,
                            'behavior' => $behavior
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Create tag service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Release tag
     *
     * @param int $id
     * @return ResponseBootstrap
     */
    public function releaseTag(string $token, int $id):ResponseBootstrap{

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
                $res = $client->post($this->configuration['tags_url'] . '/tags/release',
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Release tag service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }
}