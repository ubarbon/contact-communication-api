<?php

namespace AppBundle\Command;

use AppBundle\Service\CommunicationSyncService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CommunicationCommand
 * @package AppBundle\Command
 */
class CommunicationCommand extends Command
{
    use LockableTrait;

    /**
     * @var EntityManagerInterface $em
     */
    private $em;

    /**
     * @var CommunicationSyncService
     */
    private $communicationSyncService;

    /**
     * CommunicationCommand constructor.
     * @param EntityManagerInterface $em
     * @param CommunicationSyncService $communicationSyncService
     */
    public function __construct(EntityManagerInterface $em, CommunicationSyncService $communicationSyncService)
    {
        parent::__construct();

        $this->em = $em;
        $this->communicationSyncService = $communicationSyncService;
    }


    protected function configure()
    {
        $this
            ->setName('app:comm:sync')
            ->setDescription('Sync communication of clients')
            ->setHelp('This command allows sync communications of all clients by lot');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->lock()) {
            $message = 'The command is already running in another process.';
            $output->writeln($message);

            return 0;
        }

        $output->writeln([
            'Communication sync start',
            '============',
            '',
        ]);

        // TODO develop it, you can pass a parameter/option to the command specifying the limit you want to fetch, right now by default
        $users = $this->getEntityManager()->getRepository('AppBundle:User')->getClientToSync();

        foreach ($users as $user) {
            try {
                $this->getCommunicationSyncService()->sync($user);
            } catch (\Exception $e) {
                // TODO please treat the possible exceptions that may occur
            }
        }

        $this->getEntityManager()->flush();
        // TODO develop it , please report more messages per console, e.g total users to sync, etc

        $output->writeln([
            '============',
            'Communication sync start',
            '',
        ]);
    }

    /**
     * @return EntityManagerInterface
     */
    private function getEntityManager()
    {
        return $this->em;
    }

    /**
     * @return CommunicationSyncService
     */
    private function getCommunicationSyncService()
    {
        return $this->communicationSyncService;
    }
}