<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 10:36 AM
 */

namespace Model\Mapper;


use Component\DataMapper;

class AppsMapper extends DataMapper
{

    public function getConfiguration()
    {
        return $this->configuration;
    }
}