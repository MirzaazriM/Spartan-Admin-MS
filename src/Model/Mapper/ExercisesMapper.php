<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 11:51 AM
 */

namespace Model\Mapper;


use Component\DataMapper;

class ExercisesMapper extends DataMapper
{

    public function getConfiguration()
    {
        return $this->configuration;
    }
}