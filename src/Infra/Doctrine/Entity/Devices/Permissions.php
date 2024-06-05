<?php

namespace App\Infra\Doctrine\Entity\Devices;

use Doctrine\ORM\Mapping as ORM;
use App\Infra\Doctrine\Entity\Devices\Share;
use App\Infra\Doctrine\Repository\Devices\PermissionsRepository;

#[ORM\Entity(repositoryClass: PermissionsRepository::class)]
#[ORM\Table(name: 'devices.permissions')]
class Permissions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\ManyToOne(inversedBy: 'permissions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Share $share = null;

    private string $role;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoles(): string
    {
        return $this->role;
    }

    public function setRoles(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getShare(): ?Share
    {
        return $this->share;
    }

    public function setShare(?Share $share): static
    {
        $this->share = $share;

        return $this;
    }
}
