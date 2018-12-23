<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\AccessToken;
use Doctrine\Bundle\FixturesBundle\Fixture;
//use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AccessTokenFixtures extends Fixture implements OrderedFixtureInterface //TODO instead of DependentFixtureInterface we use OrderedFixtureInterface, why?, please see above
{
    public function load(ObjectManager $manager)
    {

        // Access without expiration to postman, etc, avoid re-login
        $exampleUserAccessTokenWithoutExpiration = new AccessToken();
        $exampleUserAccessTokenWithoutExpiration->setUser($this->getReference(UserFixtures::EXAMPLE_USERNAME));
        $exampleUserAccessTokenWithoutExpiration->setClient($this->getReference(ClientFixtures::API_CLIENT_REFERENCE));
        $exampleUserAccessTokenWithoutExpiration->setExpiresAt(null);
        $exampleUserAccessTokenWithoutExpiration->setToken('example_user_without_expiration');

        $manager->persist($exampleUserAccessTokenWithoutExpiration);

        $manager->flush();

    }

    public function getOrder()
    {
        return 2;
    }

    /*
        public function getDependencies()
        {
            return array(
                UserFixtures::class, //TODO Error The getDependencies() method returned a class (AppBundle\DataFixtures\UserFixtures) that has required constructor arguments. Upgrade to "doctrine/data-fixtures" version 1.3 or higher to support this.
                ClientFixtures::class
            );
        }*/


}