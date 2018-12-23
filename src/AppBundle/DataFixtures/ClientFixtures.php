<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ClientFixtures extends Fixture implements OrderedFixtureInterface
{
    const API_CLIENT_REFERENCE = 'api-client';
    const RANDOM_CLIENT = 'random';
    const SECRET_CLIENT = 'secret';

    public function load(ObjectManager $manager)
    {

        $apiClient = new Client();
        $apiClient->setAllowedGrantTypes(array('password')); // Right now only password grant, can add e.g.  'refresh_token', etc
        $apiClient->setRedirectUris(array('local.api.contact-communication.com'));
        $apiClient->setRandomId(self::RANDOM_CLIENT);
        $apiClient->setSecret(self::SECRET_CLIENT);

        $this->addReference(self::API_CLIENT_REFERENCE, $apiClient);
        $manager->persist($apiClient);

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}