<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeviceRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("name")
 * @Vich\Uploadable()
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
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $configFilename;

    /**
     * @var File|null
     * @Assert\File(
     *      maxSize = "2048k",
     *      mimeTypes = {"application/zip", "text/plain"}
     * )
     * @Vich\UploadableField(mapping="device_config", fileNameProperty="configFilename")
     */
    private $configFile;

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

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="devices")
     */
    private $customer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="devices")
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $maker;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $serial;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $os_version;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $mac_adress;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $domain;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\NetInterface", inversedBy="devices")
     */
    private $interfaces;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->interfaces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->name);
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addDevice($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
            $tag->removeDevice($this);
        }

        return $this;
    }

    public function getConfigFilename(): ?string
    {
        return $this->configFilename;
    }

    public function setConfigFilename(?string $configFilename): Device
    {
        $this->configFilename = $configFilename;

        return $this;
    }

    public function getConfigFile(): ?File
    {
        return $this->configFile;
    }

    public function setConfigFile(?File $configFile): Device
    {
        $this->configFile = $configFile;
        if ($this->configFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime();
        }
        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime('1000-01-01 00:00:00');
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated_at = new \DateTime('');
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getMaker(): ?string
    {
        return $this->maker;
    }

    public function setMaker(?string $maker): self
    {
        $this->maker = $maker;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getSerial(): ?string
    {
        return $this->serial;
    }

    public function setSerial(?string $serial): self
    {
        $this->serial = $serial;

        return $this;
    }

    public function getOsVersion(): ?string
    {
        return $this->os_version;
    }

    public function setOsVersion(?string $os_version): self
    {
        $this->os_version = $os_version;

        return $this;
    }

    public function getMacAdress(): ?string
    {
        return $this->mac_adress;
    }

    public function setMacAdress(?string $mac_adress): self
    {
        $this->mac_adress = $mac_adress;

        return $this;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function setDomain(?string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @return Collection|NetInterface[]
     */
    public function getInterfaces(): Collection
    {
        return $this->interfaces;
    }

    public function addInterface(NetInterface $interface): self
    {
        if (!$this->interfaces->contains($interface)) {
            $this->interfaces[] = $interface;
        }

        return $this;
    }

    public function removeInterface(NetInterface $interface): self
    {
        if ($this->interfaces->contains($interface)) {
            $this->interfaces->removeElement($interface);
        }

        return $this;
    }
}
