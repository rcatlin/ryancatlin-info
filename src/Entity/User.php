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
     * @ORM\Column(type="string")
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     name="username_canonical",
     *     unique=true
     * )
     */
    protected $usernameCanonical;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     name="email_canonical",
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
     *     name="last_login",
     *     options={"default": null}
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
     *     name="expires_at",
     *     options={"default": null}
     * )
     */
    protected $expiresAt;

    /**
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     name="confirmation_token",
     *     nullable=true,
     *     options={"default": null}
     *     )
     */
    protected $confirmationToken;

    /**
     * @var \DateTime
     *
     * @ORM\Column(
     *     type="datetime",
     *     name="password_requested_at",
     *     nullable=true,
     *     options={"default": null}
     * )
     */
    protected $passwordRequestedAt;

    /**
     * @var array
     *
     * @ORM\Column(
     *     type="string",
     *     columnDefinition="longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)'"
     * )
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
     *     nullable=true,
     *     options={"default": null}
     * )
     */
    protected $credentialsExpireAt;
}
