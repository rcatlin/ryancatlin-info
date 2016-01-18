<?php

namespace RCatlin\Blog\Entity;

use Assert\Assertion;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table()
 * @ORM\Entity(
 *     repositoryClass="RCatlin\Blog\Repository\ArticleRepository"
 * )
 * @ORM\Table(
 *     indexes={
 *         @ORM\Index(name="active_idx", columns={"active"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=100, unique=true)
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    protected $content;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(
     *      targetEntity="RCatlin\Blog\Entity\Tag",
     *      inversedBy="articles",
     *      cascade={"persist"}
     * )
     * @ORM\JoinTable(
     *      name="article_tag",
     *      joinColumns={
     *          @ORM\JoinColumn(name="article_id", referencedColumnName="id", onDelete="cascade")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="tag_id", referencedColumnName="id", onDelete="cascade")
     *      }
     * )
     */
    protected $tags;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $active;

    /**
     * @param null       $slug
     * @param null       $title
     * @param null       $content
     * @param array      $tags
     * @param bool|false $active
     */
    private function __construct(
        $slug = null,
        $title = null,
        $content = null,
        array $tags = [],
        $active = false
    ) {
        Assertion::string($slug);
        Assertion::string($title);
        Assertion::string($content);
        Assertion::boolean($active);
        Assertion::allIsInstanceOf($tags, Tag::class);

        $this->slug = $slug;
        $this->title = $title;
        $this->content = $content;
        $this->active = $active;
        $this->tags = new ArrayCollection($tags);
    }

    /**
     * @param $slug
     * @param $title
     * @param $content
     * @param array $tags
     * @param $active
     *
     * @return Article
     */
    public static function fromValues($slug, $title, $content, array $tags, $active)
    {
        return new Article($slug, $title, $content, $tags, $active);
    }

    /**
     * @param array $values
     *
     * @return Article
     */
    public static function fromArray(array $values)
    {
        $missing = array_diff(
            ['slug', 'title', 'content', 'tags', 'active'],
            array_keys($values)
        );

        if (!empty($missing)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Missing Article keys: [%s]',
                    implode(', ', $missing)
                )
            );
        }

        return self::fromValues(
            $values['slug'],
            $values['title'],
            $values['content'],
            $values['tags'],
            $values['active']
        );
    }

    /**
     * @ORM\PrePersist()
     */
    public function updateCreatedAt()
    {
        if ($this->createdAt !== null) {
            return;
        }

        $this->createdAt = $this->getCurrentDateTime();
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
     * Set slug
     *
     * @param string $slug
     *
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
     * @param string $title
     *
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
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
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
     * @param string $content
     *
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

    /**
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     *
     * @return $this
     */
    public function setTags(array $tags)
    {
        $this->tags = new ArrayCollection($tags);

        return $this;
    }

    /**
     * @param Tag $tag
     *
     * @return $this
     */
    public function addTag(Tag $tag)
    {
        // Tag is the "owning" side of the relationship
        $tag->addArticle($this);

        if ($this->tags->contains($tag)) {
            return $this;
        }

        $this->tags->add($tag);

        return $this;
    }

    /**
     * @param array $tags
     *
     * @return $this
     */
    public function addTags(array $tags)
    {
        foreach ($tags as $tag) {
            $this->addTag($tag);
        }

        return $this;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set active
     *
     * @param bool $active
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @ORM\PrePersist)
     */
    public function prePersistSetUpdatedAt()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdateUpdatedAt()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    protected function getCurrentDateTime()
    {
        return new \DateTime();
    }
}
