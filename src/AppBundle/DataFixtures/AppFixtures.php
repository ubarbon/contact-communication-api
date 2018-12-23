<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\CallCommunication;
use AppBundle\Entity\Contact;
use AppBundle\Entity\SMSCommunication;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Fake Contacts
        $fakeContact1 = new Contact();
        $fakeContact1->setName('Fake contact 1');
        $fakeContact1->setPhoneNumber('123456789');
        $fakeContact1->setUser($this->getReference(UserFixtures::EXAMPLE_USER_REF));
        $manager->persist($fakeContact1);

        $fakeContact2 = new Contact();
        $fakeContact2->setName('Fake contact 2');
        $fakeContact2->setPhoneNumber('987654321');
        $fakeContact2->setUser($this->getReference(UserFixtures::EXAMPLE_USER_REF));
        $manager->persist($fakeContact2);

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


        // Fake Communications

        //Comm wit contact 1
        $fakeComm = new CallCommunication();
        $fakeComm->setUser($this->getReference(UserFixtures::EXAMPLE_USER_REF));
        $fakeComm->setContact($fakeContact1);
        $fakeComm->setDate(new \DateTime('now'));
        $fakeComm->setIncoming(true);
        $fakeComm->setDuration('123');
        $fakeComm->setHash('call1');
        $manager->persist($fakeComm);

        $fakeComm = new CallCommunication();
        $fakeComm->setUser($this->getReference(UserFixtures::EXAMPLE_USER_REF));
        $fakeComm->setContact($fakeContact1);
        $fakeComm->setDate((new \DateTime('now'))->modify('+1 day'));
        $fakeComm->setIncoming(false);
        $fakeComm->setDuration('2');
        $fakeComm->setHash('call12');
        $manager->persist($fakeComm);

        $fakeComm = new SMSCommunication();
        $fakeComm->setUser($this->getReference(UserFixtures::EXAMPLE_USER_REF));
        $fakeComm->setContact($fakeContact1);
        $fakeComm->setDate(new \DateTime('now'));
        $fakeComm->setIncoming(false);
        $fakeComm->setHash('sms1');
        $manager->persist($fakeComm);

        $fakeComm = new SMSCommunication();
        $fakeComm->setUser($this->getReference(UserFixtures::EXAMPLE_USER_REF));
        $fakeComm->setContact($fakeContact1);
        $fakeComm->setDate((new \DateTime('now'))->modify('+1 day'));
        $fakeComm->setIncoming(true);
        $fakeComm->setHash('sms2');
        $manager->persist($fakeComm);

        $manager->flush();

    }

    public function getOrder()
    {
        return 3;
    }
}