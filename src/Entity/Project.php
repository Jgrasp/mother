<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Project
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(name: 'name', type: 'string')]
    private string $name;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'projects')]
    private Client $client;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Access::class)]
    private Collection $accesses;

    public function __construct()
    {
        $this->accesses = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;
        return $this;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getAccesses(): Collection
    {
        return $this->accesses;
    }

    public function setAccesses(ArrayCollection $accesses): Project
    {
        $this->accesses = $accesses;
        return $this;
    }

    public function hasAccesses(): bool
    {
        return $this->getAccesses()->count() > 0;
    }

    public function __toString(): string
    {
        return $this->name;
    }

}