<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 1:00 PM
 */

namespace Model\Mapper;


use Component\DataMapper;

class PushMapper extends DataMapper
{

    public function getConfiguration()
    {
        return $this->configuration;
    }
}