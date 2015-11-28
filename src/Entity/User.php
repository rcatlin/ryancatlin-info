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
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     name="username_canonical",
     *     length=255,
     *     unique=true
     * )
     */
    protected $usernameCanonical;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     name="email_canonical",
     *     length=255,
     *     unique=true
     * )
     */
    protected $emailCanonical;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $enabled;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $salt;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(
     *     type="datetime",
     *     nullable=true,
     *     name="last_login"
     * )
     */
    protected $lastLogin;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $locked;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $expired;

    /**
     * @var \DateTime
     *
     * @ORM\Column(
     *     type="datetime",
     *     nullable=true,
     *     name="expires_at"
     * )
     */
    protected $expiresAt;

    /**
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     name="confirmation_token",
     *     nullable=true
     * )
     */
    protected $confirmationToken;

    /**
     * @var \DateTime
     *
     * @ORM\Column(
     *     type="datetime",
     *     name="password_requested_at",
     *     nullable=true
     * )
     */
    protected $passwordRequestedAt;

    /**
     * @var array
     *
     * @ORM\Column(type="array")
     */
    protected $roles;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", name="credentials_expired")
     */
    protected $credentialsExpired;

    /**
     * @var \DateTime
     *
     * @ORM\Column(
     *     type="datetime",
     *     name="credentials_expire_at",
     *     nullable=true
     * )
     */
    protected $credentialsExpireAt;
}
