<?php

namespace RCatlin\Api\Entity;

use Assert\Assertion;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use RCatlin\Api\Entity;

/**
 * Tag
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RCatlin\Api\Repository\TagRepository")
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

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(
     *      targetEntity="RCatlin\Api\Entity\Article",
     *      mappedBy="tags",
     *      cascade={"persist"}
     * )
     * @ORM\JoinTable(
     *      name="article_tag",
     *      joinColumns={
     *          @ORM\JoinColumn(
     *              name="tag_id", referencedColumnName="id", onDelete="cascade"
     *          )
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(
     *              name="article_id", referencedColumnName="id", onDelete="cascade"
     *          )
     *      }
     * )
     */
    private $articles;

    private function __construct($name)
    {
        Assertion::string($name);

        $this->name = $name;
        $this->articles = new ArrayCollection();
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
     * @param array $articles
     *
     * @return $this
     */
    public function setArticles(array $articles)
    {
        $this->articles = new ArrayCollection($articles);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param Article $article
     *
     * @return $this
     */
    public function addArticle(Entity\Article $article)
    {
        if ($this->articles->contains($article)) {
            return $this;
        }

        $this->articles->add($article);

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
