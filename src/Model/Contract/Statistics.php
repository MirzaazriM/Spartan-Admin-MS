<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 8:44 AM
 */

namespace Model\Contract;


interface Statistics
{

    public function getStatistics();

    public function getTotalBugReport();

    public function getTotalExercises();

    public function getTotalTrainingPlans();

    public function getTags();

    public function getTotalUsers();

    public function getTotalWorkouts();

    public function getTotalNutritionPlans();

    public function getTotalRecepies();
}