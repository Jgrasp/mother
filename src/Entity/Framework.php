<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

use Doctrine\ORM\Mapping\OneToMany;

#[Entity]
class Framework
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'integer')]
    private int $id;

    #[Column(name: 'name', type: 'string')]
    private string $name;

    #[OneToMany(mappedBy: 'framework', targetEntity: FrameworkVersion::class)]
    private Collection $versions;

    public function __construct()
    {
        $this->versions = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Framework
    {
        $this->name = $name;
        return $this;
    }

    public function getVersions(): Collection
    {
        return $this->versions;
    }

    public function setVersions(Collection $versions): Framework
    {
        $this->versions = $versions;
        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }


}