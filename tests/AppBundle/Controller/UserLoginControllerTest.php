<?php

namespace Tests\AppBundle\Controller\User;

use AppBundle\DataFixtures\ClientFixtures;
use AppBundle\DataFixtures\UserFixtures;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserLoginControllerTest extends WebTestCase
{

    public function testLoginFailedInvalidClientByWrongIdAction()
    {
        $client = static::createClient();

        $parameters = array(
            'grant_type' => 'password',
            'client_id' => md5(microtime(true)),
            'client_secret' => ClientFixtures::SECRET_CLIENT,
            'username' => 'example@domain.com',
            'password' => 'example@domain.com'
        );

        $client->request('POST', '/oauth/v2/token', $parameters);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());

    }

    public function testLoginFailedInvalidClientByWrongSecretAction()
    {
        $client = static::createClient();

        $parameters = array(
            'grant_type' => 'password',
            'client_id' => '1_' . ClientFixtures::RANDOM_CLIENT,
            'client_secret' => md5(microtime(true)),
            'username' => 'example@domain.com',
            'password' => 'example@domain.com'
        );

        $client->request('POST', '/oauth/v2/token', $parameters);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testFailedLoginAction()
    {
        $client = static::createClient();

        $parameters = array(
            'grant_type' => 'password',
            'client_id' => '1_' . ClientFixtures::RANDOM_CLIENT,
            'client_secret' => ClientFixtures::SECRET_CLIENT,
            'username' => md5(microtime(true)),
            'password' => md5(microtime(true)),
        );

        $client->request('POST', '/oauth/v2/token', $parameters);

        $this->assertNotEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testSuccessLoginAction()
    {
        $client = static::createClient();

        $parameters = array(
            'grant_type' => 'password',
            'client_id' => '1_' . ClientFixtures::RANDOM_CLIENT,
            'client_secret' => ClientFixtures::SECRET_CLIENT,
            'username' => UserFixtures::EXAMPLE_USER_USERNAME,
            'password' => UserFixtures::EXAMPLE_USER_USERNAME
        );

        $client->request('POST', '/oauth/v2/token', $parameters);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('access_token', $data);
        $this->assertArrayHasKey('expires_in', $data);
        $this->assertArrayHasKey('token_type', $data);
        $this->assertArrayHasKey('scope', $data);
        $this->assertArrayHasKey('refresh_token', $data);
    }
}