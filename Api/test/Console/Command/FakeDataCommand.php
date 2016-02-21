<?php

namespace RCatlin\Api\Test\Console\Command;

use Doctrine\ORM\EntityManager;
use League\Container\Container;
use League\FactoryMuffin\Facade as FactoryMuffin;
use RCatlin\Api\Entity;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FakeDataCommand extends Command
{
    const ARGUMENT_ENTITY = 'entity-class';
    const ARGUMENT_AMOUNT = 'amount';

    private $factory;

    /**
     * @return array
     */
    public static function getValidEntities()
    {
        return [
            Entity\Article::class,
            Entity\Tag::class,
        ];
    }

    public function configure()
    {
        $this->setName('api:fake-data')
            ->addArgument(self::ARGUMENT_ENTITY, InputArgument::REQUIRED, 'Entity class to generate fake data.')
            ->addArgument(self::ARGUMENT_AMOUNT, InputArgument::REQUIRED, 'Amount of Entities to generate.')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $entityClass = $input->getArgument(self::ARGUMENT_ENTITY);
        $amount = $input->getArgument(self::ARGUMENT_AMOUNT);

        if (!in_array($entityClass, self::getValidEntities())) {
            throw new \InvalidArgumentException(sprintf(
                'Entity class \'%s\' is not valid.',
                $entityClass
            ));
        }

        if (!is_numeric($amount)) {
            throw new \InvalidArgumentException(sprintf(
                '\'%s\' argument must be numerical',
                self::ARGUMENT_AMOUNT
            ));
        } else {
            $amount = (int) $amount;
        }

        if ($amount <= 0) {
            throw new \InvalidArgumentException(sprintf(
                '\'%s\' argument must be greater than 0',
                self::ARGUMENT_AMOUNT
            ));
        }

        if ($entityClass === Entity\Article::class) {
            $method = 'createArticle';
        } elseif ($entityClass === Entity\Tag::class) {
            $method = 'createTag';
        } else {
            throw new \InvalidArgumentException(sprintf(
                'Invalid Entity Class \'%s\''
            ));
        }

        for ($i = 0; $i < $amount; ++$i) {
            $this->$method();
        }
    }

    private function createArticle()
    {
        $this->getFactory()->create(Entity\Article::class, [
            'active' => true,
        ]);
    }

    private function createTag()
    {
        $this->getFactory()->create(Entity\Tag::class);
    }

    /**
     * @return \League\FactoryMuffin\Factory
     */
    private function getFactory()
    {
        if ($this->factory === null) {
            /** @var Container $container */
            $container = require __DIR__ . '/../../../config/container.php';

            $entityManager = $container->get(EntityManager::class);

            $this->factory = FactoryMuffin::loadFactories(__DIR__ . '/../../../test/Factory');

            FactoryMuffin::setCustomSaver(function ($object) use ($entityManager) {
                $entityManager->persist($object);
                $entityManager->flush($object);

                return true;
            });
        }

        return $this->factory;
    }
}
