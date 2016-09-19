<?php

namespace RCatlin\Api\Console\Command;

use Doctrine\ORM\EntityManager;
use RCatlin\Api\Entity\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UserCommand extends Command
{
    const ARGUMENT_USER_NAME = 'username';
    const ARGUMENT_USER_EMAIL = 'email';
    const ARGUMENT_USER_PASSWORD = 'password';
    const NAME = 'api:user:create';

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct(self::NAME);

        $this->entityManager = $entityManager;

        $this
            ->setName(self::NAME)
            ->addArgument(self::ARGUMENT_USER_NAME, InputArgument::REQUIRED, 'User Name')
            ->addArgument(self::ARGUMENT_USER_EMAIL, InputArgument::REQUIRED, 'User Email')
            ->addArgument(self::ARGUMENT_USER_PASSWORD, InputArgument::REQUIRED, 'User Password');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);

        $user = User::fromArray([
            'username' => $input->getArgument(self::ARGUMENT_USER_NAME),
            'email' => $input->getArgument(self::ARGUMENT_USER_EMAIL),
            'password' => $input->getArgument(self::ARGUMENT_USER_PASSWORD),
        ]);

        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush($user);
        } catch (\Exception $e) {
            $style->error($e->getMessage());
            return;
        }

        $style->success(sprintf(
            'Successfully created a User (id: %s)', $user->getId()
        ));
    }

    public function getName()
    {
        return self::NAME;
    }
}
