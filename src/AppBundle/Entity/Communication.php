<?php

namespace AppBundle\Entity;

use AppBundle\Component\Client\Log\Log;
use AppBundle\Model\CommunicationTypeInterface;

/**
 * Communication
 */
abstract class Communication
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $hash;

    /**
     * @var bool
     */
    private $incoming;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var User
     */
    private $user;

    /**
     * @var Contact
     */
    private $contact;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set hash
     *
     * @param string $hash
     *
     * @return Communication
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set incoming
     *
     * @param boolean $incoming
     *
     * @return Communication
     */
    public function setIncoming($incoming)
    {
        $this->incoming = $incoming;

        return $this;
    }

    /**
     * Get incoming
     *
     * @return bool
     */
    public function getIncoming()
    {
        return $this->incoming;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Communication
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Communication
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Contact
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param Contact $contact
     * @return Communication
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @param User $user
     * @param Contact $contact
     * @param Log $log
     * @return CallCommunication|SMSCommunication
     * @throws \Exception
     */
    public static function build(User $user, Contact $contact, Log $log)
    {
        $communication = $log->getTypeValue() === CommunicationTypeInterface::CALL ? new CallCommunication() : new SMSCommunication();

        $communication->setHash($log->getHash());
        $communication->setUser($user);
        $communication->setContact($contact);
        $communication->setIncoming($log->getIncomingValue());
        $communication->setDate($log->getDate());

        if ($communication instanceof CallCommunication) {
            $communication->setDuration($log->getDurationValue());
        }

        return $communication;
    }
}

