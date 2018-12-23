<?php

namespace AppBundle\Entity;

use FOS\OAuthServerBundle\Entity\AccessToken as BaseAccessToken;

class AccessToken extends BaseAccessToken
{
    /**
     * @var integer
     */
    protected $id;
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var User
     */
    protected $user;
}