<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 11:38 AM
 */

namespace Model\Mapper;


use Component\DataMapper;

class WorkoutsMapper extends DataMapper
{

    public function getConfiguration()
    {
        return $this->configuration;
    }
}