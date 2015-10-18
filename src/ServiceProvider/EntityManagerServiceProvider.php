<?php

namespace RCatlin\Blog\ServiceProvider;

use Assert\Assertion;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use League\Container\ServiceProvider\AbstractServiceProvider;

class EntityManagerServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        EntityManager::class,
    ];

    /**
     * @var string
     */
    private $dbName;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $driver;

    /**
     * @var string
     */
    private $entityDir;

    /**
     * @var bool
     */
    private $isProd;

    /**
     * @param string $dbName
     * @param string $user
     * @param string $password
     * @param string $host
     * @param string $driver
     * @param string $entityDir
     * @param mixed $isProd
     */
    public function __construct($dbName, $user, $password, $host, $driver, $entityDir, $isProd = false)
    {
        Assertion::string($dbName);
        Assertion::string($user);
        Assertion::string($password);
        Assertion::string($host);
        Assertion::string($driver);
        Assertion::string($entityDir);
        Assertion::directory($entityDir);

        $this->dbName = $dbName;
        $this->user = $user;
        $this->password = $password;
        $this->host = $host;
        $this->driver = $driver;
        $this->entityDir = $entityDir;
        $this->isProd = boolval($isProd);
    }

    /**
     * {inheritDoc}
     */
    public function register()
    {
        $conn = \Doctrine\DBAL\DriverManager::getConnection([
            'dbname' => $this->dbName,
            'user' => $this->user,
            'password' => $this->password,
            'host' => $this->host,
            'driver' => $this->driver,
        ]);

        $config = Setup::createAnnotationMetadataConfiguration([$this->entityDir], $this->isProd, null, null, false);

        $this->getContainer()->share(EntityManager::class, function () use ($conn, $config) {
            return EntityManager::create($conn, $config);
        });
    }
}
