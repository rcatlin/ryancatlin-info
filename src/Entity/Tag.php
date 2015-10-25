<?php

namespace RCatlin\Blog\Entity;

use Assert\Assertion;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tag
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RCatlin\Blog\Repository\TagRepository")
 */
class Tag
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, unique=true)
     */
    private $name;

    private function __construct($name)
    {
        Assertion::string($name);

        $this->name = $name;
    }

    /**
     * @param $name
     *
     * @return Tag
     */
    public static function fromValues($name)
    {
        return new Tag($name);
    }

    /**
     * @param array $values
     *
     * @return Tag
     */
    public static function fromArray(array $values)
    {
        if (!isset($values['name'])) {
            throw new \InvalidArgumentException('Missing name value.');
        }

        return self::fromValues($values['name']);
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Tag
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
