<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 7/16/18
 * Time: 12:14 PM
 */

namespace Component;


class LinksConfiguration
{

    // environment
    private $config = 'LOCAL';

    // local
    private $localTagsUrl = 'http://spartan-tags:8888';
    private $localNutritionPlansUrl = 'http://spartan-nutrition-plans:8888';
    private $localWorkoutPlansUrl = 'http://spartan-workout-plans:8888';
    private $localExercisesUrl = 'http://spartan-exercises:8888';
    private $localSystemUrl = 'http://spartan-system:8888';
    private $localMonologUrl = 'http://spartan-monolog:8888';
    private $localPackagesUrl = 'http://spartan-packages:8888';
    private $localNotificationsUrl = 'http://spartan-notifications:8888';
    private $localRecepiesUrl = 'http://spartan-recepies:8888';
    private $localUsersUrl = 'http://spartan-users:8888';
    private $localWorkoutsUrl = 'http://spartan-workouts:8888';
    private $localAppsUrl = 'http://spartan-apps:8888';

    // online
    private $onlineTagsUrl = '56.43.214.09';
    private $onlineNutritionPlansUrl = '324.67.98.12';
    private $onlineWorkoutPlansUrl = '111.234.566.09';
    private $onlineExercisesUrl = '111.234.566.09';
    private $onlineSystemUrl = '56.43.214.09';
    private $onlineMonologUrl = '111.234.566.09';
    private $onlinePackagesUrl = '56.43.214.09';
    private $onlineNotificationsUrl = '111.234.566.09';
    private $onlineRecepiesUrl = '56.43.214.09';
    private $onlineUsersUrl = '111.234.566.09';
    private $onlineWorkoutsUrl = '56.43.214.09';
    private $onlineAppsUrl = '111.234.566.09';

    public function __construct()
    {
    }

    /**
     * Get urls
     *
     * @return array
     */
    public function getUrls():array {

        if($this->config == 'LOCAL'){
            return [
                $this->localTagsUrl,  // 0
                $this->localNutritionPlansUrl,  // 1
                $this->localWorkoutPlansUrl,  // 2
                $this->localExercisesUrl,  // 3
                $this->localSystemUrl,  // 4
                $this->localMonologUrl,  // 5
                $this->localPackagesUrl,  // 6
                $this->localNotificationsUrl,  // 7
                $this->localRecepiesUrl,  // 8
                $this->localUsersUrl,  // 9
                $this->localWorkoutsUrl,  // 10
                $this->localAppsUrl, // 11
            ];
        }else {
            return [
                $this->onlineTagsUrl,
                $this->onlineNutritionPlansUrl,
                $this->onlineWorkoutPlansUrl,
                $this->onlineExercisesUrl,
                $this->onlineSystemUrl,
                $this->onlineMonologUrl,
                $this->onlinePackagesUrl,
                $this->onlineNotificationsUrl,
                $this->onlineRecepiesUrl,
                $this->onlineUsersUrl,
                $this->onlineWorkoutsUrl,
                $this->onlineAppsUrl
            ];
        }
    }
}