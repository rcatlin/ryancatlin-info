<?php

namespace RCatlin\Api\Repository;

use Assert\Assertion;
use Doctrine\ORM\EntityRepository;
use RCatlin\Api\Entity;

class UserRepository extends EntityRepository
{
    /**
     * @param string $username
     *
     * @return null|object|Entity\User
     */
    public function findOneByUsername($username)
    {
        Assertion::string($username);

        return $this->findOneBy([
            'username' => $username,
        ]);
    }
}
