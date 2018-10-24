<?php
/**
 * Created by PhpStorm.
 * User: mirza
 * Date: 6/27/18
 * Time: 1:38 PM
 */

namespace Model\Service;


use Model\Entity\ResponseBootstrap;
use Model\Mapper\LoginMapper;

class LoginService
{

    private $loginMapper;

    public function __construct(LoginMapper $loginMapper)
    {
        $this->loginMapper = $loginMapper;
    }


    public function getLogin():ResponseBootstrap {

    }

    public function login():ResponseBootstrap {

    }

    public function token():ResponseBootstrap {

    }

    public function callback():ResponseBootstrap {

    }
}