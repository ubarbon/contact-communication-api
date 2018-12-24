<?php

namespace AppBundle\Service;

use AppBundle\Component\Client\Log\Log;
use AppBundle\Component\Client\Log\LogClient;
use AppBundle\Component\Client\Log\LogHelper;
use AppBundle\Entity\Communication;
use AppBundle\Entity\Contact;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CommunicationSyncService
 * @package AppBundle\Service
 */
class CommunicationSyncService
{
    /**
     * @var EntityManagerInterface $em
     */
    private $em;

    /**
     * @var LogClient
     */
    private $logClient;

    /**
     * @var Contact[] $contactContainer
     */
    private $contactContainer;

    /**
     * CommunicationSyncService constructor.
     * @param EntityManagerInterface $em
     * @param LogClient $logClient
     */
    public function __construct(EntityManagerInterface $em, LogClient $logClient)
    {
        $this->em = $em;
        $this->logClient = $logClient;
        $this->resetContactContainer();
    }


    /**
     * @param User $user
     * @param boolean $doFlush
     */
    public function sync(User $user, $doFlush = false)
    {
        $this->resetContactContainer();

        try {
            $logContent = $this->getLogClient()->getCommunicationLog($user);

            $logsResult = LogHelper::getLogs($logContent);
            foreach ($logsResult as $log) {
                $this->syncCommunicationToUser($user, $log);
            }

            $user->setLastSync(new \DateTime());

            if ($doFlush) {
                $this->getEntityManager()->flush();
            }

        } catch (\Exception $e) {
            //TODO please do something
        }
    }

    /**
     * @return EntityManagerInterface
     */
    private function getEntityManager()
    {
        return $this->em;
    }

    /**
     * @return LogClient
     */
    private function getLogClient()
    {
        return $this->logClient;
    }

    /**
     * @return Contact[]
     */
    private function getContactContainer()
    {
        return $this->contactContainer;
    }

    /**
     * @param User $user
     * @param Log $log
     * @throws \Exception
     */
    private function syncCommunicationToUser(User $user, Log $log)
    {
        $contact = $this->getContact($user, $log);

        if ($contact->getId() && $this->getEntityManager()->getRepository('AppBundle:Communication')->existsCommunicationBy($user->getId(), $contact->getId(), $log->getHash())) {
            return; // Contact already exists and communication is founded
        }

        // Create communication
        $communication = Communication::build($user, $contact, $log);

        $this->getEntityManager()->persist($communication);
    }

    /**
     * @param User $user
     * @param Log $log
     * @return Contact
     */
    private function getContact(User $user, Log $log)
    {
        if (!$contact = $this->findContactInContainerBy($log->getContactPhoneNumber())) {
            $contact = $this->getEntityManager()->getRepository('AppBundle:Contact')->findOneBy(array(
                'phoneNumber' => $log->getContactPhoneNumber(),
                'user' => $user->getId()
            ));

            if ($contact) {
                $this->pushContact($contact);
            }

        }

        return $contact ?: $this->createContact($user, $log);
    }

    /**
     * @param User $user
     * @param Log $log
     * @return Contact
     */
    private function createContact(User $user, Log $log)
    {
        $contact = new Contact();
        $contact->setUser($user);
        $contact->setPhoneNumber($log->getContactPhoneNumber());
        $contact->setName($log->getContactNameValue());

        $this->getEntityManager()->persist($contact);

        $this->pushContact($contact);

        return $contact;
    }

    private function resetContactContainer()
    {
        $this->contactContainer = array();
    }

    /**
     * @param Contact $contact
     */
    private function pushContact(Contact $contact)
    {
        $this->contactContainer[] = $contact;
    }

    /**
     * @param int $phoneNumber
     * @return Contact|null
     */
    private function findContactInContainerBy($phoneNumber)
    {
        foreach ($this->getContactContainer() as $contact) {
            if ($contact->getPhoneNumber() === $phoneNumber) {
                return $contact;
            }
        }

        return null;
    }
}
