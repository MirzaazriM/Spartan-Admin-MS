<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 12:31 PM
 */

namespace Model\Mapper;


use Component\DataMapper;

class RecepiesMapper extends DataMapper
{

    public function getConfiguration()
    {
        return $this->configuration;
    }
}