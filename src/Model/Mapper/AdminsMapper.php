<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/26/18
 * Time: 6:22 PM
 */

namespace Model\Mapper;

use PDO;
use Model\Entity\AdminCollection;
use Model\Entity\Shared;
use PDOException;
use Component\DataMapper;
use Model\Entity\Admin;

class AdminsMapper extends DataMapper
{


    public function getConfiguration()
    {
        return $this->configuration;
    }


    /**
     * Fetch admin data
     *
     * @param Admin $admin
     * @return Admin
     */
    public function getAdmin(Admin $admin):Admin {

        // create response object
        $response = new Admin();

        try {

            // set database instructions
            $sql = "SELECT * FROM admins WHERE id = ?";
            $statement = $this->connection->prepare($sql);
            $statement->execute([
                $admin->getId()
            ]);

            // fetch data
            $data = $statement->fetch();

            // set response values if data exists
            if($statement->rowCount() > 0){
                $response->setId($data['id']);
                $response->setName($data['name']);
                $response->setSurname($data['surname']);
                $response->setEmail($data['email']);
                $response->setState($data['state']);
                $response->setScope($data['scope']);
            }

        }catch(PDOException $e){
            // send monolog record
            $this->monologHelper->sendMonologRecord($this->configuration, $e->errorInfo[1], "Get admin mapper: " . $e->getMessage());
        }

        // return data
        return $response;
    }


    /**
     * Get all admins
     *
     * @return AdminCollection
     */
    public function getAdmins():AdminCollection {

        // create response object
        $adminCollection = new AdminCollection();

        try {

            // set database instructions
            $sql = "SELECT * FROM admins";
            $statement = $this->connection->prepare($sql);
            $statement->execute();

            // loop through data and set data to admin collection
            while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                // create admin entity
                $admin = new Admin();

                // set admin values
                $admin->setId($row['id']);
                $admin->setName($row['name']);
                $admin->setSurname($row['surname']);
                $admin->setEmail($row['email']);
                $admin->setScope($row['scope']);
                $admin->setState($row['state']);

                // add admin to admin collection
                $adminCollection->addEntity($admin);
            }

            // set response according to result of previous actions
            if($statement->rowCount() == 0){
                $adminCollection->setStatusCode(204);
            }else {
                $adminCollection->setStatusCode(200);
            }

        }catch(PDOException $e){
            $adminCollection->setStatusCode(204);
            // send monolog record
            $this->monologHelper->sendMonologRecord($this->configuration, $e->errorInfo[1], "Get admins mapper: " . $e->getMessage());
        }

        // return data
        return $adminCollection;
    }


    /**
     * Add admin
     *
     * @param Admin $admin
     * @return Shared
     */
    public function addAdmin(Admin $admin):Shared {

        // create response object
        $shared = new Shared();

        try {

            // set database instructions
            $sql = "INSERT INTO
                      admins
                    (name, surname, email, scope)
                    VALUES (?,?,?,?)";
            $statement = $this->connection->prepare($sql);
            $statement->execute([
                $admin->getName(),
                $admin->getSurname(),
                $admin->getEmail(),
                $admin->getScope()
            ]);

            // set response according to the result of previous action
            if($statement->rowCount() > 0){
                $shared->setResponse([200]);
            }else {
                $shared->setResponse([304]);
            }

        }catch(PDOException $e){
            $shared->setResponse([304]);
            // send monolog record
            $this->monologHelper->sendMonologRecord($this->configuration, $e->errorInfo[1], "Add admin mapper: " . $e->getMessage());
        }

        // return response
        return $shared;
    }


    /**
     * Edit admin
     *
     * @param Admin $admin
     * @return Shared
     */
    public function editAdmin(Admin $admin):Shared {

        // create response object
        $shared = new Shared();

        try {

            // set database instructions
            $sql = "UPDATE admins SET 
                      name = ?, 
                      surname = ?, 
                      email = ?, 
                      scope = ?, 
                      state = ?
                    WHERE id = ?";
            $statement = $this->connection->prepare($sql);
            $statement->execute([
                $admin->getName(),
                $admin->getSurname(),
                $admin->getEmail(),
                $admin->getScope(),
                $admin->getState(),
                $admin->getId()
            ]);

            // set response according to the result of previous action
            if($statement->rowCount() > 0){
                $shared->setResponse([200]);
            }else {
                $shared->setResponse([304]);
            }

        }catch(PDOException $e){
            $shared->setResponse([304]);
            // send monolog record
            $this->monologHelper->sendMonologRecord($this->configuration, $e->errorInfo[1], "Edit admin mapper: " . $e->getMessage());
        }

        // return response
        return $shared;
    }


    /**
     * Delete admin
     *
     * @param Admin $admin
     * @return Shared
     */
    public function deleteAdmin(Admin $admin):Shared {

        // create response object
        $shared = new Shared();

        try {

            // set database instructions
            $sql = "DELETE FROM admins WHERE id = ?";
            $statement = $this->connection->prepare($sql);
            $statement->execute([
                $admin->getId()
            ]);

            // set response according to the result of previous action
            if($statement->rowCount() > 0){
                $shared->setResponse([200]);
            }else {
                $shared->setResponse([304]);
            }

        }catch(PDOException $e){
            $shared->setResponse([304]);
            // send monolog record
            $this->monologHelper->sendMonologRecord($this->configuration, $e->errorInfo[1], "Delete admin mapper: " . $e->getMessage());
        }

        // return response
        return $shared;
    }
}