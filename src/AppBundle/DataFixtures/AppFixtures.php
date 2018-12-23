<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $fakeContact = new Contact();
        $fakeContact->setName('Fake contact 1');
        $fakeContact->setPhoneNumber('123456789');
        $fakeContact->setUser($this->getReference(UserFixtures::EXAMPLE_USER_REF));
        $manager->persist($fakeContact);

        $fakeContact = new Contact();
        $fakeContact->setName('Fake contact 2');
        $fakeContact->setPhoneNumber('987654321');
        $fakeContact->setUser($this->getReference(UserFixtures::EXAMPLE_USER_REF));
        $manager->persist($fakeContact);

        $fakeContact = new Contact();
        $fakeContact->setName('Fake contact 3');
        $fakeContact->setPhoneNumber('543216789');
        $fakeContact->setUser($this->getReference(UserFixtures::EXAMPLE_USER_REF));
        $manager->persist($fakeContact);

        $fakeContact = new Contact();
        $fakeContact->setName('Fake contact 4');
        $fakeContact->setPhoneNumber('678954321');
        $fakeContact->setUser($this->getReference(UserFixtures::EXAMPLE_USER_REF));
        $manager->persist($fakeContact);

        $manager->flush();

    }

    public function getOrder()
    {
        return 3;
    }
}