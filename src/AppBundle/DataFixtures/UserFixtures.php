<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{

    const EXAMPLE_USER_REF = 'example-user';

    const EXAMPLE_USER_EMAIL = 'example@domain.com';
    const EXAMPLE_USER_USERNAME = '611111111'; // Phone number like username

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
        $user = new User();
        $user->setPhoneNumber(self::EXAMPLE_USER_USERNAME); // Because username is a phone number
        $user->setEnabled(true);
        $user->setUsername(self::EXAMPLE_USER_USERNAME);
        $user->setEmail(self::EXAMPLE_USER_EMAIL);
        $user->addRole('ROLE_USER');

        $password = $this->encoder->encodePassword($user, $user->getUsername()); // Password same username
        $user->setPassword($password);

        $this->addReference(self::EXAMPLE_USER_REF, $user);
        $manager->persist($user);


        $manager->flush();
    }

    public function getOrder()
    {
        return 0;
    }
}