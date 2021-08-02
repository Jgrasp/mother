<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Protocol
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(name: 'name', type: 'string')]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'protocol', targetEntity: Access::class)]
    private Collection $accesses;

    public function __construct()
    {
        $this->accesses = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Protocol
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Protocol
    {
        $this->name = $name;
        return $this;
    }

    public function getAccesses(): Collection
    {
        return $this->accesses;
    }

    public function __toString(): string
    {
        return $this->getName();
    }


}