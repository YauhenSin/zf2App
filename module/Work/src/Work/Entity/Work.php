<?php

namespace Work\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */

class Work
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $artistId;

    /** @ORM\Column(type="string") */
    protected $name;

    /** @ORM\Column(type="string") */
    protected $description;

    /** @ORM\Column(type="decimal") */
    protected $price;

    /** @ORM\Column(type="string") */
    protected $pictureHash;

    /** @ORM\Column(type="string") */
    protected $pictureName;


    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToOne(targetEntity="Work\Entity\Genre")
     * @ORM\JoinTable(name="work_genre_linker",
     *      joinColumns={@ORM\JoinColumn(name="work_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="genre_id", referencedColumnName="id")}
     * )
     */
    protected $genre;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setArtistId($artistId)
    {
        $this->artistId = $artistId;
    }

    public function getArtistId()
    {
        return $this->artistId;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPictureHash($pictureHash)
    {
        $this->pictureHash = $pictureHash;
    }

    public function getPictureHash()
    {
        return $this->pictureHash;
    }

    public function setPictureName($pictureName)
    {
        $this->pictureName = $pictureName;
    }

    public function getPictureName()
    {
        return $this->pictureName;
    }

    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    public function getGenre()
    {
        return $this->genre;
    }
}
