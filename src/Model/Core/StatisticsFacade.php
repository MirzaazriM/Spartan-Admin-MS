<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 8:56 AM
 */

namespace Model\Core;

use Model\Contract\Statistics;

class StatisticsFacade implements Statistics
{
    private $bigData = [];
    private $configuration;

    public function __construct($connection)
    {
        $this->configuration = $connection->getConfiguration();
    }

    public function getStatistics(){
        // get all data
        $this->getTotalBugReport();
        $this->getTotalExercises();
        $this->getTotalTrainingPlans();
        $this->getTags();
        $this->getTotalUsers();
        $this->getTotalWorkouts();
        $this->getTotalNutritionPlans();
        $this->getTotalRecepies();

        return $this->bigData;
    }


    public function getTotalBugReport(){
        // create guzzle client and call MS for data
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $this->configuration['monolog_url'] . '/monolog/total', []);

        $data = $response->getBody()->getContents();

        if(!!empty($data)){
            $this->bigData['bug_reports'] = implode('', json_decode($data));
        }else {
            $this->bigData['bug_reports'] = 0;
        }
    }


    public function getTotalExercises(){
        // create guzzle client and call MS for data
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $this->configuration['exercises_url'] . '/exercises/total', []);

        $data = $response->getBody()->getContents();

        if(!empty($data)){
            $this->bigData['total_exercises'] = implode('', json_decode($data));
        }else {
            $this->bigData['total_exercises'] = 0;
        }
    }


    public function getTotalTrainingPlans(){
        // create guzzle client and call MS for data
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $this->configuration['workoutplans_url'] . '/workoutplans/total', []);

        $data = $response->getBody()->getContents();

        if(!empty($data)){
            $this->bigData['training_plans'] = implode('', json_decode($data));
        }else {
            $this->bigData['training_plans'] = 0;
        }
    }


    public function getTags(){
        // create guzzle client and call MS for data
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $this->configuration['tags_url'] . '/tags/total', []);

        $data = $response->getBody()->getContents();

        if(!empty($data)){
            $this->bigData['tags'] = implode('', json_decode($data));
        }else {
            $this->bigData['tags'] = 0;
        }
    }


    public function getTotalUsers(){
        // create guzzle client and call MS for data
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $this->configuration['users_url'] . '/users/total', []);

        $data = $response->getBody()->getContents();

        if(!empty($data)){
            $this->bigData['total_users'] = implode('', json_decode($data));
        }else {
            $this->bigData['total_users'] = 0;
        }
    }


    public function getTotalWorkouts(){
        // create guzzle client and call MS for data
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $this->configuration['workouts_url'] . '/workouts/total', []);

        $data = $response->getBody()->getContents();

        if(!empty($data)){
            $this->bigData['total_workouts'] = implode('', json_decode($data));
        }else {
            $this->bigData['total_workouts'] = 0;
        }
    }


    public function getTotalNutritionPlans(){
        // create guzzle client and call MS for data
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $this->configuration['nutritionplans_url'] . '/nutritionplans/total', []);

        $data = $response->getBody()->getContents();

        if(!empty($data)){
            $this->bigData['total_nutrition_plans'] = implode('', json_decode($data));
        }else {
            $this->bigData['total_nutrition_plans'] = 0;
        }

    }


    public function getTotalRecepies(){
        // create guzzle client and call MS for data
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $this->configuration['recepies_url'] . '/recepie/total', []);

        $data = $response->getBody()->getContents();

        if(!empty($data)){
            $this->bigData['total_recepies'] = implode('', json_decode($data));
        }else {
            $this->bigData['total_recepies'] = 0;
        }

    }

}