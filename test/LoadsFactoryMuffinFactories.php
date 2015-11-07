<?php

namespace RCatlin\Blog\Test;

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

        $entityManager = self::$entityManager;

        FactoryMuffin::setCustomSaver(function ($object) use ($entityManager) {
            $entityManager->persist($object);
            $entityManager->flush($object);

            return true;
        });
    }

    public static function tearDownBeforeClass()
    {
        $entityManager = self::$entityManager;

        FactoryMuffin::setCustomDeleter(function ($object) use ($entityManager) {
            $entityManager->remove($object);
            $entityManager->flush();
        });
        FactoryMuffin::deleteSaved();

        parent::tearDownAfterClass();
    }
}
