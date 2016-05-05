<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repositories\PictureRepository")
 * @ORM\Table(name="picture", options={})
 */
class Picture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Album", fetch="EXTRA_LAZY", inversedBy="pictures")
     */
    private $album;

    /**
     * @ORM\Column(type="integer")
     */
    private $album_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $thumbnail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;

    /**
     * @Groups({"short", "full"})
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @Groups({"full"})
     * @return mixed
     */
    public function getAlbumId()
    {
        return $this->album_id;
    }

    /**
     * @Groups({"short", "full"})
     * @return mixed
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @param mixed $thumbnail
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @Groups({"full"})
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @Groups({"full"})
     * @return mixed
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param mixed $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @Groups({"short"})
     * @return string
     */
    public function getResource()
    {
        return sprintf("/picture/%d", $this->getId());
    }
}
