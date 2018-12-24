<?php

namespace AppBundle\Component\Client\Log;

use AppBundle\Entity\User;
use GuzzleHttp\Client;

/**
 * Class LogClient
 * @package AppBundle\Component\Client\Log
 */
class LogClient
{

    const GET_PHONE_NUMBER_COMMUNICATION_LOG = '/communications.{phoneNumber}.log';

    /**
     * @var string
     */
    private $endpoint;

    /**
     * @var Client
     */
    private $client;

    /**
     * BucoClient constructor.
     * @param string $endpoint
     */
    public function __construct($endpoint)
    {
        $this->endpoint = $endpoint;
        $this->client = new Client(['http_errors' => false]);
    }

    /**
     * @param User $user
     * @return \Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCommunicationLog(User $user)
    {
        //TODO develop rest call log
        $uri = $this->getEndpoint() . $this->getCommunicationLogEndpoint($user);
        $resource = $this->getClient()->request('GET', $uri);

        return $resource->getBody();
    }

    /**
     * @return string
     */
    private function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @return Client
     */
    private function getClient()
    {
        return $this->client;
    }

    /**
     * @param User $user
     * @return string
     */
    private function getCommunicationLogEndpoint(User $user)
    {
        return str_replace('{phoneNumber}', $user->getPhoneNumber(), self::GET_PHONE_NUMBER_COMMUNICATION_LOG);
    }
}