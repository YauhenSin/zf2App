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
}
