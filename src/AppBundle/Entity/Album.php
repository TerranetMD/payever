<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repositories\AlbumRepository")
 * @ORM\Table(name="album", indexes={
 *     @ORM\Index(name="name", columns={"name"}),
 *     @ORM\Index(name="created_at", columns={"created_at"})
 * })
 */
class Album
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity="Picture", fetch="EXTRA_LAZY", mappedBy="album")
     */
    private $pictures;

    /**
     * @Groups({"short", "full"})
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @Groups({"short", "full"})
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @Groups({"short", "full"})
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at->format(DateTime::ISO8601);
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @Groups({"short", "full"})
     * @return string
     */
    public function getResource()
    {
        return sprintf("/album/%d/pictures", $this->getId());
    }

    /**
     * @Groups({"short"})
     * @param int $count
     * @return mixed
     */
    public function getCovers()
    {
        return is_object($this->pictures) ? $this->pictures->slice(0, 4) : [];
    }
}
