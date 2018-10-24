<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/26/18
 * Time: 6:21 PM
 */

namespace Model\Service;


use Model\Core\Helper\Monolog\MonologSender;
use Model\Entity\Admin;
use Model\Entity\ResponseBootstrap;
use Model\Entity\ScopeEnum;
use Model\Mapper\AdminsMapper;
use Model\Service\Helper\AuthHelper;
use Symfony\Component\Config\Definition\Exception\Exception;

class AdminsService
{

    private $adminsMapper;
    private $configuration;
    private $monologHelper;

    public function __construct(AdminsMapper $adminsMapper){
        $this->adminsMapper = $adminsMapper;
        $this->configuration = $adminsMapper->getConfiguration();
        $this->monologHelper = new MonologSender();
    }


    /**
     * Get admin by id
     *
     * @param int $id
     * @return ResponseBootstrap
     */
    public function getAdmin(string $token, int $id):ResponseBootstrap {

        try {
            // create response object
            $response = new ResponseBootstrap();

            // check authorization
//        $authController = new AuthHelper($token, $scope = 'all', $this->configuration);
//        $allowed = $authController->checkAuthorization();
            $allowed = 200; // DEMO

            if($allowed == 200){
                // create entity and set its values
                $entity = new Admin();
                $entity->setId($id);

                // call mapper to fetch data
                $data = $this->adminsMapper->getAdmin($entity);
                $id = $data->getId();

                // set response
                if(isset($id)){
                    $response->setStatus(200);
                    $response->setMessage('Success');
                    $response->setData([
                        'data' => [
                            'id' => $data->getId(),
                            'name' => $data->getName(),
                            'surname' => $data->getSurname(),
                            'email' => $data->getEmail(),
                            'scope' => $data->getScope(),
                            'state' => $data->getState()
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Get admin service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Get all admins
     *
     * @return ResponseBootstrap
     */
    public function getAdmins(string $token):ResponseBootstrap {

        try {
            // create response object
            $response = new ResponseBootstrap();

            // check authorization
//        $authController = new AuthHelper($token, $scope = 'all', $this->configuration);
//        $allowed = $authController->checkAuthorization();
            $allowed = 200; //

            if($allowed == 200){
                // get response
                $res = $this->adminsMapper->getAdmins();

                // convert data from collection to array for response
                $data = [];
                for($i = 0; $i < count($res); $i++){
                    $data[$i]['id'] = $res[$i]->getId();
                    $data[$i]['name'] = $res[$i]->getName();
                    $data[$i]['surname'] = $res[$i]->getSurname();
                    $data[$i]['email'] = $res[$i]->getEmail();
                    $data[$i]['scope'] = $res[$i]->getScope();
                    $data[$i]['state'] = $res[$i]->getState();
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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Get admins service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Add admin service
     *
     * @param string $name
     * @param string $surname
     * @param string $email
     * @param string $scope
     * @return ResponseBootstrap
     */
    public function addAdmin(string $name, string $surname, string $email, string $scope):ResponseBootstrap {

        try {
            // create response object
            $response = new ResponseBootstrap();

            // check authorization
//        $authController = new AuthHelper($token, $scope = 'all', $this->configuration);
//        $allowed = $authController->checkAuthorization();
            $allowed = 200; // DEMO

            if($allowed == 200){
                // create admin entity and set its values
                $admin = new Admin();
                $admin->setName($name);
                $admin->setSurname($surname);
                $admin->setEmail($email);
                // $admin->setState($state);
                $admin->setScope($scope);

                // get response
                $res = $this->adminsMapper->addAdmin($admin)->getResponse();

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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Add admin service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Update admin
     *
     * @param int $id
     * @param string $name
     * @param string $surname
     * @param string $email
     * @param string $scope
     * @param string $state
     * @return ResponseBootstrap
     */
    public function editAdmin(int $id, string $name, string $surname, string $email, string $scope, string $state):ResponseBootstrap {

        try {
            // create response object
            $response = new ResponseBootstrap();

            // check authorization
//        $authController = new AuthHelper($token, $scope = 'all', $this->configuration);
//        $allowed = $authController->checkAuthorization();
            $allowed = 200; // DEMO

            if($allowed == 200){
                // create admin entity and set its values
                $admin = new Admin();
                $admin->setId($id);
                $admin->setName($name);
                $admin->setSurname($surname);
                $admin->setEmail($email);
                $admin->setState($state);
                $admin->setScope($scope);

                // get response
                $res = $this->adminsMapper->editAdmin($admin)->getResponse();

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

        }catch (\Exception $e) {
            // send monolog record
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Edit admin service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }


    /**
     * Delete admin
     *
     * @param int $id
     * @return ResponseBootstrap
     */
    public function deleteAdmin(int $id):ResponseBootstrap {

        try {
            // create response object
            $response = new ResponseBootstrap();

            // check authorization
//        $authController = new AuthHelper($token, $scope = 'all', $this->configuration);
//        $allowed = $authController->checkAuthorization();
            $allowed = 200; // DEMO

            if($allowed == 200){
                // create entity and set values
                $admin = new Admin();
                $admin->setId($id);

                // get response
                $res = $this->adminsMapper->deleteAdmin($admin)->getResponse();

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
            $this->monologHelper->sendMonologRecord($this->configuration, 1000, "Delete admin service: " . $e->getMessage());

            $response->setStatus(404);
            $response->setMessage('Invalid data');
            return $response;
        }
    }

}