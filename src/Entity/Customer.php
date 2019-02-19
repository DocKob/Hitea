<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 */
class Customer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\device", mappedBy="customer")
     */
    private $devices;

    public function __construct()
    {
        $this->devices = new ArrayCollection();
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

    public function getDescription() : ? string
    {
        return $this->description;
    }

    public function setDescription(? string $description) : self
    {
        $this->description = $description;

        return $this;
    }

    public function getAdress() : ? string
    {
        return $this->adress;
    }

    public function setAdress(? string $adress) : self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getPhone() : ? string
    {
        return $this->phone;
    }

    public function setPhone(? string $phone) : self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection|device[]
     */
    public function getDevices(): Collection
    {
        return $this->devices;
    }

    public function addDevice(device $device): self
    {
        if (!$this->devices->contains($device)) {
            $this->devices[] = $device;
            $device->setCustomer($this);
        }

        return $this;
    }

    public function removeDevice(device $device): self
    {
        if ($this->devices->contains($device)) {
            $this->devices->removeElement($device);
            // set the owning side to null (unless already changed)
            if ($device->getCustomer() === $this) {
                $device->setCustomer(null);
            }
        }

        return $this;
    }
}
