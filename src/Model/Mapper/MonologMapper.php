<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 9:20 AM
 */

namespace Model\Mapper;

use Component\DataMapper;

class MonologMapper extends DataMapper
{

    public function getConfiguration()
    {
        return $this->configuration;
    }
}