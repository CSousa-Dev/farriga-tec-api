<?php

namespace App\Infra\Doctrine\Entity\Account;

use Doctrine\ORM\Mapping as ORM;
use App\Infra\Doctrine\Entity\Account\Email;
use App\Infra\Doctrine\Entity\UserSecurityInfo;
use App\Domain\Account\Repository\UserRepository;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`account.user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 55)]
    private ?string $firstName = null;

    #[ORM\Column(length: 55)]
    private ?string $lastName = null;

    #[ORM\Column(length: 55)]
    private ?string $document = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?DocumentType $documentType = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Email $email = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?UserSecurityInfo $securityInfo = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?Address $address = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getDocument(): ?string
    {
        return $this->document;
    }

    public function setDocument(string $document): static
    {
        $this->document = $document;

        return $this;
    }

    public function getDocumentType(): ?DocumentType
    {
        return $this->documentType;
    }

    public function setDocumentType(?DocumentType $documentType): static
    {
        $this->documentType = $documentType;

        return $this;
    }

    public function getEmail(): ?Email
    {
        return $this->email;
    }

    public function setEmail(Email $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getSecurityInfo(): ?UserSecurityInfo
    {
        return $this->securityInfo;
    }

    public function setSecurityInfo(?UserSecurityInfo $securityInfo): static
    {
        $this->securityInfo = $securityInfo;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): static
    {
        $this->address = $address;

        return $this;
    }
}
