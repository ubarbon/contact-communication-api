<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{

    const EXAMPLE_USERNAME = 'example@domain.com';

    /**
     * @var UserPasswordEncoderInterface $encoder
     */
    private $encoder;

    /**
     * UserFixture constructor.
     * @param $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {
        //Example User
        $userRoot = new User();
        $userRoot->setEnabled(true);
        $userRoot->setUsername(self::EXAMPLE_USERNAME);
        $userRoot->setEmail(self::EXAMPLE_USERNAME);
        $userRoot->addRole('ROLE_USER');

        $password = $this->encoder->encodePassword($userRoot, $userRoot->getUsername());
        $userRoot->setPassword($password);

        $this->addReference(self::EXAMPLE_USERNAME, $userRoot);
        $manager->persist($userRoot);


        $manager->flush();
    }

    public function getOrder()
    {
        return 0;
    }
}