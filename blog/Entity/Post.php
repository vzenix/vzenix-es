<?php
namespace VZenix\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="VZenix\Bundle\BlogBundle\Repository\PostRepository")
 * @ORM\Table(name="vz_posts",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="friendly_idx", columns={"friendly"})})
 * @ORM\HasLifecycleCallbacks
 */
class Post
{

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="VZenix\Bundle\BlogBundle\Entity\Author", inversedBy="posts")
     */
    private $author;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $friendly;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $subtitle;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $metatags;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $summary;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @var datetime $created
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var datetime $updated
     * @ORM\Column(type="datetime", nullable = true)
     */
    protected $updated;

    /**
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated = new \DateTime("now");
    }

    /**
     * Get ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return string for friendly uri
     */
    public function getFriendly()
    {
        return $this->friendly;
    }

    /**
     * Get Title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get Content
     */
    public function getContent(bool $replace = false)
    {
        return $this->content;
    }

    /**
     * Get Date created post
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Get Date edited post
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Get image for the post
     */
    public function getImage()
    {
        return is_string($this->image) && $this->image != "" ? $this->image : "";
    }

    /**
     * Get the subtitle for the post
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Get summary
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /** Meta tags for header html */
    public function getMetaTags()
    {
        return $this->metatags;
    }

    /**
     * @return \VZenix\Bundle\BlogBundle\Entity\Author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * return \VZenix\Bundle\BlogBundle\Entity\Post
     */
    public function setAuthor(Author $author)
    {
        $this->author = $author;
        return $this;
    }

}