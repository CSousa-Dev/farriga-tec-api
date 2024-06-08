<?php

namespace App\Infra\Doctrine\Entity\Devices;

use Doctrine\ORM\Mapping as ORM;
use App\Infra\Doctrine\Entity\Account\User;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Infra\Doctrine\Repository\Devices\ShareRepository;

#[ORM\Entity(repositoryClass: ShareRepository::class)]
#[ORM\Table(name: 'devices.share')]
class Share
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'sharedDevices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $receiver = null;

    #[ORM\ManyToOne(inversedBy: 'mySharing')]
    private ?User $sharer = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Device $device = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $sharedAt = null;

    /**
     * @var Collection<int, Permissions>
     */
    #[ORM\OneToMany(targetEntity: Permissions::class, mappedBy: 'share', orphanRemoval: true)]
    private Collection $permissions;

    public function __construct()
    {
        $this->permissions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReceiver(): ?User
    {
        return $this->receiver;
    }

    public function setReceiver(?User $receiver): static
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function getSharer(): ?User
    {
        return $this->sharer;
    }

    public function setSharer(?User $sharer): static
    {
        $this->sharer = $sharer;

        return $this;
    }

    public function getDevice(): ?Device
    {
        return $this->device;
    }

    public function setDevice(?Device $device): static
    {
        $this->device = $device;

        return $this;
    }

    public function getSharedAt(): ?\DateTimeImmutable
    {
        return $this->sharedAt;
    }

    public function setSharedAt(\DateTimeImmutable $sharedAt): static
    {
        $this->sharedAt = $sharedAt;

        return $this;
    }

    /**
     * @return Collection<int, Permissions>
     */
    public function getPermissions(): Collection
    {
        return $this->permissions;
    }

    public function addPermission(Permissions $permission): static
    {
        if (!$this->permissions->contains($permission)) {
            $this->permissions->add($permission);
            $permission->setShare($this);
        }

        return $this;
    }

    public function removePermission(Permissions $permission): static
    {
        if ($this->permissions->removeElement($permission)) {
            // set the owning side to null (unless already changed)
            if ($permission->getShare() === $this) {
                $permission->setShare(null);
            }
        }

        return $this;
    }
}
