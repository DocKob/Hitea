<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;


class DeviceSearch
{

    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getTags() : ArrayCollection
    {
        return $this->tags;
    }

    public function setTags(ArrayCollection $tags) : void
    {
        $this->tags = $tags;
    }

}