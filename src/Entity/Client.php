<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(name: 'name', type: 'string')]
    private string $name;

    #[ORM\ManyToOne(targetEntity: ClientType::class)]
    private ClientType $type;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Project::class)]
    private Collection $projects;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setType(ClientType $type): Client
    {
        $this->type = $type;
        return $this;
    }

    public function getType(): ClientType
    {
        return $this->type;
    }

    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function hasProject(): bool
    {
        return $this->countProject() > 0;
    }

    public function countProject(): int
    {
        return $this->getProjects()->count();
    }

    public function __toString(): string
    {
        return $this->name;
    }

}