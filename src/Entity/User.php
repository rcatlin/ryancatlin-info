<?php

namespace RCatlin\Blog\Entity;

use Doctrine\ORM\Mapping as ORM;

// TODO: Add additional properties lost with removal of FOSUserBundle BaseUser

/**
 * @ORM\Entity(repositoryClass="RCatlin\Blog\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}
