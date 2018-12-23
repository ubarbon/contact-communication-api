<?php

namespace Tests\AppBundle\Controller;

use AppBundle\DataFixtures\ClientFixtures;
use AppBundle\DataFixtures\UserFixtures;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractPreAuthenticatedTest extends WebTestCase
{
    /**
     * @var array $accessUser
     */
    private static $userAccess = null;

    /**
     * @param string $method
     * @param string $uri
     * @param array $parameters
     * @param array $files
     * @param array $server
     * @param null $content
     * @param bool $changeHistory
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    public function makeRequestWithAccess($method, $uri, array $parameters = array(), array $files = array(), array $server = array(), $content = null, $changeHistory = true)
    {
        $access = $this->getUserAccess();

        return $this->_requestWithAccessToken($access['access_token'], $method, $uri, $parameters, $files, $server, $content, $changeHistory);
    }

    /**
     * @return array
     */
    private function getUserAccess()
    {
        if (self::$userAccess === null) {
            self::$userAccess = $this->login(UserFixtures::EXAMPLE_USER_USERNAME, UserFixtures::EXAMPLE_USER_USERNAME);
        }

        return self::$userAccess;
    }

    /**
     * @param string $username
     * @param string $password
     * @return array
     */
    private function login($username, $password)
    {
        $client = static::createClient();

        $parameters = array(
            'grant_type' => 'password',
            'client_id' => '1_' . ClientFixtures::RANDOM_CLIENT,
            'client_secret' => ClientFixtures::SECRET_CLIENT,
            'username' => $username,
            'password' => $password
        );

        $client->request('POST', '/oauth/v2/token', $parameters);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('access_token', $data);
        $this->assertArrayHasKey('expires_in', $data);
        $this->assertArrayHasKey('token_type', $data);
        $this->assertArrayHasKey('scope', $data);
        $this->assertArrayHasKey('refresh_token', $data);

        return $data;
    }

    /**
     * @param string $accessToken
     * @param string $method
     * @param string $uri
     * @param array $parameters
     * @param array $files
     * @param array $server
     * @param null $content
     * @param bool $changeHistory
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    private function _requestWithAccessToken($accessToken, $method, $uri, array $parameters = array(), array $files = array(), array $server = array(), $content = null, $changeHistory = true)
    {
        $client = static::createClient();

        $server = array_merge(array(
            'HTTP_Authorization' => 'Bearer ' . $accessToken
        ), $server);

        $client->request($method, $uri, $parameters, $files, $server, $content, $changeHistory);

        return $client;
    }
}
