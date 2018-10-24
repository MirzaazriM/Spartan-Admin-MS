<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 8:32 AM
 */

namespace Model\Mapper;


use Component\DataMapper;

class StatisticsMapper extends DataMapper
{

    public function getConfiguration()
    {
        return $this->configuration;
    }
}