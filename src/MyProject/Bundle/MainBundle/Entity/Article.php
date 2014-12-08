<?php

namespace MyProject\Bundle\MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table()
 * @ORM\Entity(
 *     repositoryClass="MyProject\Bundle\MainBundle\Entity\ArticleRepository"
 * )
 * @ORM\Table(
 *     indexes={
 *         @ORM\Index(name="slug_idx", columns={"slug"}),
 *         @ORM\Index(name="active_idx", columns={"active"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks
 */
class Article
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=100, unique=true)
     * @Assert\Regex(
     *     pattern = "/^[0-9a-zA-Z\-\_]+$/"
     * )
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetimetz")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetimetz")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Tag")
     */
    protected $tags;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $active;

    public function __construct()
    {
        $now = new \DateTime();
        $this->setCreatedAt($now);
        $this->setUpdatedAt($now);
        $this->tags = new ArrayCollection();
        $this->active = false;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set slug
     *
     * @param  string  $slug
     * @return Article
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set title
     *
     * @param  string  $title
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set createdAt
     *
     * @param  \DateTime $createdAt
     * @return Article
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param  \DateTime $updatedAt
     * @return Article
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set content
     *
     * @param  string  $content
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function addTags(array $tags)
    {
        foreach ($tags as $tag) {
            $this->tags->add($tag);
        }
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set active
     *
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdateUpdatedAt()
    {
        $this->updatedAt = new \DateTime();
    }
}
