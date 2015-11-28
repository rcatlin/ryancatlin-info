<?php

namespace RCatlin\Blog\Test;

use Doctrine\ORM\EntityManager;
use League\FactoryMuffin\Facade as FactoryMuffin;

/**
 * Loads Facades using league\factory-muffin. Meant to be used in Integration Tests
 * that extend AbstractIntegrationTest.
 */
trait LoadsFactoryMuffinFactories
{
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        FactoryMuffin::loadFactories(__DIR__ . '/Factory');

        /** @var EntityManager $entityManager */
        $entityManager = self::$entityManager;

        FactoryMuffin::setCustomSaver(function ($object) use ($entityManager) {
            $entityManager->persist($object);
            $entityManager->flush($object);

            return true;
        });

        FactoryMuffin::setCustomDeleter(function ($object) use ($entityManager) {
            if (!$entityManager->contains($object)) {
                return true;
            }

            $entityManager->remove($object);
            $entityManager->flush();

            return true;
        });
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();

        FactoryMuffin::deleteSaved();
    }
}
