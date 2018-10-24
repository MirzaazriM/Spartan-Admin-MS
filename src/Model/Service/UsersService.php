<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 12:46 PM
 */

namespace Model\Service;


use Component\LinksConfiguration;
use Model\Core\Helper\Monolog\MonologSender;
use Model\Entity\ResponseBootstrap;
use Model\Mapper\UsersMapper;
use Model\Service\Helper\AuthHelper;

class UsersService extends LinksConfiguration
{

    private $usersMapper;
    private $configuration;
    private $monologHelper;

    public function __construct(UsersMapper $usersMapper)
    {
        $this->usersMapper = $usersMapper;
        $this->configuration = $usersMapper->getConfiguration();
        $this->monologHelper = new MonologSender();
    }


    /**
     * Get user by id
     *
     * @param int $id
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUser(string $token, int $id):ResponseBootstrap{

        try {
            // create response object
            $response = new ResponseBootstrap();

            // check authorization
//         $authController = new AuthHelper($token, $scope = 'all', $this->configuration);
//        $allowed = $authController->checkAuthorization();
            $allowed = 200; // DEMO

            if($allowed == 200){
                // create guzzle client and call MS for data
                $client = new \GuzzleHttp\Client();
                $res = $client->request('GET', $this->configuration['users_url'] . '/users?id=' . $id, []);

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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Get user service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Get user by app or search term
     *
     * @param string|null $app
     * @param string|null $like
     * @return ResponseBootstrap
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUsers(string $token, string $app = null, string $like = null):ResponseBootstrap {

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
                $res = $client->request('GET', $this->configuration['users_url'] . '/users/all?like=' . $like . '&app=' . $app, []);

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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Get users service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Edit user
     *
     * @param string $id
     * @param string $name
     * @param string $surname
     * @param string $email
     * @param string $location
     * @return ResponseBootstrap
     */
    public function editUser(string $token, string $id, string $name, string $surname, string $email, string $location):ResponseBootstrap {

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
                $res = $client->put($this->configuration['users_url'] . '/users',
                    [
                        \GuzzleHttp\RequestOptions::JSON => [
                            'id' => $id,
                            'name' => $name,
                            'surname' => $surname,
                            'email' => $email,
                            'location' => $location
                        ]
                    ]);

                // check status response
                $code = $res->getStatusCode();

                //die(print_r($data));
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Edit user service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Add user
     *
     * @param string $name
     * @param string $surname
     * @param string $email
     * @param string $location
     * @return ResponseBootstrap
     */
    public function addUser(string $token, string $name, string $surname, string $email, string $location):ResponseBootstrap {

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
                $res = $client->post($this->configuration['users_url'] . '/users',
                    [
                        \GuzzleHttp\RequestOptions::JSON => [
                            'name' => $name,
                            'surname' => $surname,
                            'email' => $email,
                            'location' => $location
                        ]
                    ]);

                // check status response
                $code = $res->getStatusCode();

                //die(print_r($data));
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Add user service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }

}