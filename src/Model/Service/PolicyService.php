<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/26/18
 * Time: 9:34 PM
 */

namespace Model\Service;


use Model\Core\Helper\Monolog\MonologSender;
use Model\Entity\Policy;
use Model\Entity\ResponseBootstrap;
use Model\Mapper\PolicyMapper;
use Model\Service\Helper\AuthHelper;

class PolicyService
{

    private $policyMapper;
    private $configuration;
    private $monologHelper;

    public function __construct(PolicyMapper $policyMapper)
    {
        $this->policyMapper = $policyMapper;
        $this->configuration = $policyMapper->getConfiguration();
        $this->monologHelper = new MonologSender();
    }


    /**
     * Get single policy
     *
     * @param int $id
     * @return ResponseBootstrap
     */
    public function getPolicy(string $token, int $id):ResponseBootstrap {

        try {
            // create response object
            $response = new ResponseBootstrap();

            // check authorization
//        $authController = new AuthHelper($token, $scope = 'all', $this->configuration);
//        $allowed = $authController->checkAuthorization();
            $allowed = 200; // DEMO

            if($allowed == 200){
                // create entity and set its values
                $entity = new Policy();
                $entity->setId($id);

                // call mapper to fetch data
                $data = $this->policyMapper->getPolicy($entity);
                $id = $data->getId();

                // set response
                if(isset($id)){
                    $response->setStatus(200);
                    $response->setMessage('Success');
                    $response->setData([
                        'data' => [
                            'id' => $data->getId(),
                            'title' => $data->getTitle(),
                            'body' => $data->getBody(),
                            'date' => $data->getDate()
                        ]
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Get policy service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Get all policies
     *
     * @return ResponseBootstrap
     */
    public function getPolicies(string $token):ResponseBootstrap {

        try {
            // create response object
            $response = new ResponseBootstrap();

            // check authorization
//        $authController = new AuthHelper($token, $scope = 'all', $this->configuration);
//        $allowed = $authController->checkAuthorization();
            $allowed = 200; // DEMO

            if($allowed == 200){
                // get response
                $res = $this->policyMapper->getPolicies();

                // convert data from collection to array for response
                $data = [];
                for($i = 0; $i < count($res); $i++){
                    $data[$i]['id'] = $res[$i]->getId();
                    $data[$i]['title'] = $res[$i]->getTitle();
                    $data[$i]['body'] = $res[$i]->getBody();
                    $data[$i]['date'] = $res[$i]->getDate();
                }

                // check data and set response
                if($res->getStatusCode() == 200){
                    $response->setStatus(200);
                    $response->setMessage('Success');
                    $response->setData([
                        'data' => $data
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Get policies service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Add policy
     *
     * @param string $title
     * @param string $body
     * @return ResponseBootstrap
     */
    public function addPolicy(string $token, string $title, string $body):ResponseBootstrap {

        try {
            // create response object
            $response = new ResponseBootstrap();

            // check authorization
//        $authController = new AuthHelper($token, $scope = 'all', $this->configuration);
//        $allowed = $authController->checkAuthorization();
            $allowed = 200; // DEMO

            if($allowed == 200){
                // create entity and set its values
                $entity = new Policy();
                $entity->setTitle($title);
                $entity->setBody($body);

                // get response
                $res = $this->policyMapper->addPolicy($entity)->getResponse();

                // check data and set response
                if($res[0] == 200){
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Add policy service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Update policy
     *
     * @param int $id
     * @param string $title
     * @param string $body
     * @return ResponseBootstrap
     */
    public function editPolicy(string $token, int $id, string $title, string $body):ResponseBootstrap {

        try {
            // create response object
            $response = new ResponseBootstrap();

            // check authorization
//        $authController = new AuthHelper($token, $scope = 'all', $this->configuration);
//        $allowed = $authController->checkAuthorization();
            $allowed = 200; // DEMO

            if($allowed == 200){
                // create entity and set its values
                $entity = new Policy();
                $entity->setId($id);
                $entity->setTitle($title);
                $entity->setBody($body);

                // get response
                $res = $this->policyMapper->editPolicy($entity)->getResponse();

                // check data and set response
                if($res[0] == 200){
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Edit policy service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Delete policy
     *
     * @param int $id
     * @return ResponseBootstrap
     */
    public function deletePolicy(string $token, int $id):ResponseBootstrap {

        try {
            // create response object
            $response = new ResponseBootstrap();

            // check authorization
//        $authController = new AuthHelper($token, $scope = 'all', $this->configuration);
//        $allowed = $authController->checkAuthorization();
            $allowed = 200; // DEMO

            if($allowed == 200){
                // create entity and set values
                $entity = new Policy();
                $entity->setId($id);

                // get response
                $res = $this->policyMapper->deletePolicy($entity)->getResponse();

                // check data and set response
                if($res[0] == 200){
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Delete policy service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }

}