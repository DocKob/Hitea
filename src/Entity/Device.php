<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeviceRepository")
 * @UniqueEntity("name")
 */
class Device
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[a-zA-Z0-9\-\_ ]+$/")
     * @Assert\Length(min= 3, max=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(max=300)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Ip
     * @Assert\NotBlank
     */
    private $ip;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="boolean", options={"default": true})
     */
    private $active = true;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="devices")
     */
    private $tags;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->tags = new ArrayCollection();
    }

    public function getId() : ? int
    {
        return $this->id;
    }

    public function getName() : ? string
    {
        return $this->name;
    }

    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug() : string
    {
        return (new Slugify())->slugify($this->name);
    }

    public function getDescription() : ? string
    {
        return $this->description;
    }

    public function setDescription(? string $description) : self
    {
        $this->description = $description;

        return $this;
    }

    public function getIp() : ? string
    {
        return $this->ip;
    }

    public function setIp(string $ip) : self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getCreatedAt() : ? \DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at) : self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt() : ? \DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at) : self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getActive() : ? bool
    {
        return $this->active;
    }

    public function setActive(bool $active) : self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags() : Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag) : self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addDevice($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag) : self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
            $tag->removeDevice($this);
        }

        return $this;
    }
}
