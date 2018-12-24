<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;

class User extends BaseUser
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    private $phoneNumber;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Set phoneNumber
     *
     * @param integer $phoneNumber
     *
     * @return User
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return integer
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }
}