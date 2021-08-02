<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;


#[Entity]
#[HasLifecycleCallbacks]
class Access
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'integer')]
    private int $id;

    #[Column(name: 'host', type: 'string')]
    private string $host;

    #[Column(name: 'path', type: 'string', nullable: true)]
    private ?string $path;

    #[Column(name: 'username', type: 'string', nullable: true)]
    private ?string $username;

    #[Column(name: 'password', type: 'string', nullable: true)]
    private ?string $password;

    #[Column(name: 'port', type: 'integer', nullable: true)]
    private ?int $port;

    #[ManyToOne(targetEntity: Environment::class, inversedBy: 'accesses')]
    private Environment $environment;

    #[ManyToOne(targetEntity: AccessType::class, inversedBy: 'accesses')]
    private AccessType $type;

    #[ManyToOne(targetEntity: Protocol::class, inversedBy: 'accesses')]
    private Protocol $protocol;

    #[ManyToOne(targetEntity: Project::class, inversedBy: 'accesses')]
    private Project $project;

    public function getId(): int
    {
        return $this->id;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function setHost(string $host): Access
    {
        $this->host = $host;
        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): Access
    {
        $this->path = $path;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): Access
    {
        $this->username = $username;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): Access
    {
        $this->password = $password;
        return $this;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function setPort(?int $port): Access
    {
        $this->port = $port;
        return $this;
    }

    public function getEnvironment(): Environment
    {
        return $this->environment;
    }

    public function setEnvironment(Environment $environment): Access
    {
        $this->environment = $environment;
        return $this;
    }

    public function getType(): AccessType
    {
        return $this->type;
    }

    public function setType(AccessType $type): Access
    {
        $this->type = $type;
        return $this;
    }

    public function getProtocol(): Protocol
    {
        return $this->protocol;
    }

    public function setProtocol(Protocol $protocol): Access
    {
        $this->protocol = $protocol;
        return $this;
    }

    public function getProject(): Project
    {
        return $this->project;
    }

    public function setProject(Project $project): Access
    {
        $this->project = $project;
        return $this;
    }

    public function getClient(): Client
    {
        return $this->getProject()->getClient();
    }

}