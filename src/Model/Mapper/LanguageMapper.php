<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 10:15 AM
 */

namespace Model\Mapper;


use Component\DataMapper;

class LanguageMapper extends DataMapper
{

    public function getConfiguration()
    {
        return $this->configuration;
    }
}