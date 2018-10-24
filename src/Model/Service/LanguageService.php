<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 10:15 AM
 */

namespace Model\Service;


use Component\LinksConfiguration;
use Model\Core\Helper\Monolog\MonologSender;
use Model\Entity\ResponseBootstrap;
use Model\Mapper\LanguageMapper;
use Model\Service\Helper\AuthHelper;

class LanguageService extends LinksConfiguration
{
    private $languageMapper;
    private $configuration;
    private $monologHelper;

    public function __construct(LanguageMapper $languageMapper){
        $this->languageMapper = $languageMapper;
        $this->configuration = $languageMapper->getConfiguration();
        $this->monologHelper = new MonologSender();
    }


    /**
     * Get specified language
     *
     * @param int $id
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getLanguage(string $token, int $id):ResponseBootstrap {

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
                $res = $client->request('GET', $this->configuration['system_url'] . '/language?id=' . $id, []);

                // set data to variable
                $data = $res->getBody()->getContents();

                // set response
                if(!empty($data)){
                    $response->setStatus(200);
                    $response->setMessage('Success');
                    $response->setData(
                        ['data' => json_decode($data)]
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Get language service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Get all languages
     *
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getLanguages(string $token):ResponseBootstrap {

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
                $res = $client->request('GET', $this->configuration['system_url'] . '/language', []);

                // set data to variable
                $data = $res->getBody()->getContents();
                // die($data);

                // set response
                if(!empty($data)){
                    $response->setStatus(200);
                    $response->setMessage('Success');
                    $response->setData(
                        ['data' => json_decode($data)]
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Get languages service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Delete language
     *
     * @param string $token
     * @param int $id
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteLanguage(string $token, int $id):ResponseBootstrap {

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
                $res = $client->request('DELETE', $this->configuration['system_url'] . '/language?id=' . $id, []);

                // check status response
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Delete language service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Add language
     *
     * @param string $name
     * @return ResponseBootstrap
     */
    public function addLanguage(string $token, string $name, string $iso):ResponseBootstrap {

        try {
            // create response object
            $response = new ResponseBootstrap();

            // check authorization
//        $authController = new AuthHelper($token, $scope = 'all', $this->configuration);
//        $allowed = $authController->checkAuthorization();
            $allowed = 200; // DEMO

            if($allowed == 200){
                // create guzzle client and send it data for email
                $client = new \GuzzleHttp\Client();
                $res = $client->post($this->configuration['system_url'] . '/language',
                    [
                        \GuzzleHttp\RequestOptions::JSON => [
                            'name' => $name,
                            'iso' => $iso
                        ]
                    ]);

                // check status response
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Add language service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Edit language
     *
     * @param int $id
     * @param string $name
     * @return ResponseBootstrap
     */
    public function editLanguage(string $token, int $id, string $name, string $iso):ResponseBootstrap {

        try {
            // create response object
            $response = new ResponseBootstrap();

            // check authorization
//        $authController = new AuthHelper($token, $scope = 'all', $this->configuration);
//        $allowed = $authController->checkAuthorization();
            $allowed = 200; // DEMO

            if($allowed == 200){
                // create guzzle client and send it data for email
                $client = new \GuzzleHttp\Client();
                $res = $client->put($this->configuration['system_url'] . '/language',
                    [
                        \GuzzleHttp\RequestOptions::JSON => [
                            'id' => $id,
                            'name' => $name,
                            'iso' => $iso
                        ]
                    ]);

                // check status response
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Edit language service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }

}