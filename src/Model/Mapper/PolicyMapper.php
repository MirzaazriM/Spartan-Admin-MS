<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/26/18
 * Time: 9:34 PM
 */

namespace Model\Mapper;

use Model\Entity\Policy;
use Model\Entity\PolicyCollection;
use Model\Entity\Shared;
use PDO;
use PDOException;
use Component\DataMapper;

class PolicyMapper extends  DataMapper
{

    public function getConfiguration()
    {
        return $this->configuration;
    }


    /**
     * Fetch policy
     *
     * @param Policy $policy
     * @return Policy
     */
    public function getPolicy(Policy $policy):Policy {

        // create response object
        $response = new Policy();

        try {

            // set database instructions
            $sql = "SELECT * FROM policies WHERE id = ?";
            $statement = $this->connection->prepare($sql);
            $statement->execute([
                $policy->getId()
            ]);

            // fetch data
            $data = $statement->fetch();

            // set response according to result of previous action
            if($statement->rowCount() > 0){
                $response->setId($data['id']);
                $response->setTitle($data['title']);
                $response->setBody($data['body']);
                $response->setDate($data['date']);
            }

        }catch(PDOException $e){
            // send monolog record
            $this->monologHelper->sendMonologRecord($this->configuration, $e->errorInfo[1], "Get policy mapper: " . $e->getMessage());
        }

        // return data
        return $response;
    }


    /**
     * Fetch all policies
     *
     * @return PolicyCollection
     */
    public function getPolicies():PolicyCollection {

        // create response object
        $policyCollection = new PolicyCollection();

        try {

            // set database instructions
            $sql = "SELECT * FROM policies";
            $statement = $this->connection->prepare($sql);
            $statement->execute();

            // loop through data and set policy entity values
            while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                // create policy entity
                $policy = new Policy();

                // set policy values
                $policy->setId($row['id']);
                $policy->setTitle($row['title']);
                $policy->setBody($row['body']);
                $policy->setDate($row['date']);

                // add entity to policy collection
                $policyCollection->addEntity($policy);
            }

            // set response according to result of previous action
            if($statement->rowCount() == 0){
                $policyCollection->setStatusCode(204);
            }else {
                $policyCollection->setStatusCode(200);
            }

        }catch(PDOException $e){
            $policyCollection->setStatusCode(204);
            // send monolog record
            $this->monologHelper->sendMonologRecord($this->configuration, $e->errorInfo[1], "Get polices mapper: " . $e->getMessage());
        }

        // return data
        return $policyCollection;
    }


    /**
     * Add policy
     *
     * @param Policy $policy
     * @return Shared
     */
    public function addPolicy(Policy $policy):Shared {

        // create response object
        $shared = new Shared();

        try {

            // set database instructions
            $sql = "INSERT INTO policies 
                       (title, body)
                    VALUES(?,?)";
            $statement = $this->connection->prepare($sql);
            $statement->execute([
                $policy->getTitle(),
                $policy->getBody()
            ]);

            // set response according to result of previous action
            if($statement->rowCount() > 0){
                $shared->setResponse([200]);
            }else {
                $shared->setResponse([304]);
            }

        }catch(PDOException $e){
            $shared->setResponse([304]);
            // send monolog record
            $this->monologHelper->sendMonologRecord($this->configuration, $e->errorInfo[1], "Add policy mapper: " . $e->getMessage());
        }

        // return response
        return $shared;
    }


    /**
     * Edit policy
     *
     * @param Policy $policy
     * @return Shared
     */
    public function editPolicy(Policy $policy):Shared {

        // create response object
        $shared = new Shared();

        try {

            // set database instructions
            $sql = "UPDATE policies SET
                      title = ?,
                      body = ?
                    WHERE id = ?";
            $statement = $this->connection->prepare($sql);
            $statement->execute([
                $policy->getTitle(),
                $policy->getBody(),
                $policy->getId()
            ]);

            // set response according to result of previous action
            if($statement->rowCount() > 0){
                $shared->setResponse([200]);
            }else {
                $shared->setResponse([304]);
            }

        }catch(PDOException $e){
            $shared->setResponse([304]);
            // send monolog record
            $this->monologHelper->sendMonologRecord($this->configuration, $e->errorInfo[1], "Edit policy mapper: " . $e->getMessage());
        }

        // return response
        return $shared;
    }


    /**
     * Delete policy
     *
     * @param Policy $policy
     * @return Shared
     */
    public function deletePolicy(Policy $policy):Shared {

        // create response object
        $shared = new Shared();

        try {

            // set database instructions
            $sql = "DELETE FROM policies WHERE id = ?";
            $statement = $this->connection->prepare($sql);
            $statement->execute([
                $policy->getId()
            ]);

            // set response according to result of previous action
            if($statement->rowCount() > 0){
                $shared->setResponse([200]);
            }else {
                $shared->setResponse([304]);
            }

        }catch(PDOException $e){
            $shared->setResponse([304]);
            // send monolog record
            $this->monologHelper->sendMonologRecord($this->configuration, $e->errorInfo[1], "Delete policy mapper: " . $e->getMessage());
        }

        // return response
        return $shared;
    }

}