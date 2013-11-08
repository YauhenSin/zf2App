<?php

namespace Album\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */

class Album
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /** @ORM\Column(type="string") */
    protected $artist;

    /** @ORM\Column(type="string") */
    protected $title;

    public function setArtist($artist)
    {
        $this->artist = $artist;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getArtist()
    {
        return $this->artist;
    }
}
