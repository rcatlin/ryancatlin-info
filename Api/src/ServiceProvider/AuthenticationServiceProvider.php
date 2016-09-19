<?php

namespace RCatlin\Api\ServiceProvider;

use Doctrine\ORM\EntityManager;
use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\Api\Authentication;
use RCatlin\Api\Repository;

class AuthenticationServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Authentication\Login::class,
    ];

    /**
     * @var string
     */
    private $secret;

    /**
     * @var string
     */
    private $issuer;

    /**
     * @param string $secret
     * @param string $issuer
     */
    public function __construct($secret, $issuer)
    {
        $this->secret = $secret;
        $this->issuer = $issuer;
    }

    public function register()
    {
        $this->container->share(Authentication\Login::class, function () {
            $entityManager = $this->container->get(EntityManager::class);
            $userRepository = $this->container->get(Repository\UserRepository::class);

            return new Authentication\Login(
                $entityManager,
                $userRepository,
                $this->secret,
                $this->issuer
            );
        });
    }
}
