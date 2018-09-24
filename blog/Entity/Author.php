<?php
namespace VZenix\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="VZenix\Bundle\BlogBundle\Repository\AuthorRepository")
 * @ORM\Table(name="vz_author")
 * @ORM\HasLifecycleCallbacks
 */
class Author
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="VZenix\Bundle\BlogBundle\Entity\Author", mappedBy="author")
     */
    private $posts;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $website;

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

    /** Constructor */
    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

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
     * Get Author name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get Image of author
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Get Website of author
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @return Collection|Post[]
     */
    public function getProducts(): Collection
    {
        return $this->posts;
    }

}