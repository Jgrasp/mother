<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;

#[Entity]
class FrameworkVersion
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'integer')]
    private int $id;

    #[Column(name: 'host', type: 'string')]
    private string $value;

    #[ManyToOne(targetEntity: Framework::class, inversedBy: 'versions')]
    private Framework $framework;

    #[OneToMany(mappedBy: 'version', targetEntity: Access::class)]
    private Collection $accesses;

    public function __construct()
    {
        $this->accesses = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): FrameworkVersion
    {
        $this->value = $value;
        return $this;
    }

    public function getFramework(): Framework
    {
        return $this->framework;
    }

    public function setFramework(Framework $framework): FrameworkVersion
    {
        $this->framework = $framework;
        return $this;
    }

    public function getAccesses(): Collection
    {
        return $this->accesses;
    }

    public function setAccesses(Collection $accesses): FrameworkVersion
    {
        $this->accesses = $accesses;
        return $this;
    }

    public function __toString(): string
    {
        return $this->getFramework()->getName().' - '.$this->getValue();
    }


}