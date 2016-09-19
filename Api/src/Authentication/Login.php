<?php

namespace RCatlin\Api\Authentication;

use Assert\Assertion;
use Doctrine\ORM\EntityManager;
use Firebase\JWT\JWT;
use RCatlin\Api\Repository;

class Login
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Repository\UserRepository
     */
    private $userRepository;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $issuer;

    /**
     * @param EntityManager $entityManager
     * @param Repository\UserRepository $userRepository
     * @param string $key
     * @param string $issuer
     */
    public function __construct(
        EntityManager $entityManager,
        Repository\UserRepository $userRepository,
        $key,
        $issuer
    ) {
        Assertion::string($key);
        Assertion::string($issuer);

        $this->entityManager =  $entityManager;
        $this->userRepository = $userRepository;
        $this->key = $key;
        $this->issuer = $issuer;
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return string|null
     */
    public function loginUserFromCredentials($username, $password)
    {
        Assertion::string($username);
        Assertion::string($password);

        $user = $this->userRepository->findOneByUsername($username);

        if (!$user) {
            return;
        }

        $salted = hash('SHA256', $password, $user->getSalt());

        if (!($user->getPassword() === $salted)) {
            return;
        }

        $now = $this->getNow();

        return JWT::encode(
            [
                'iss' => $this->issuer,
                'aud' => $this->issuer,
                'iat' => $now,
                'nbf' => $now + 60,
                'exp' => $now + 3600,
            ],
            $this->key,
            'HS256'
        );
    }

    /**
     * @return int
     */
    protected function getNow()
    {
        return time();
    }
}
