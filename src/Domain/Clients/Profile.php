<?php

namespace Carguru\VendorBundle\Domain\Clients;

use Doctrine\ORM\Mapping as ORM;
use Carguru\VendorBundle\Traits\EntityIdTrait;
use Carguru\VendorBundle\Traits\TimestampableTrait;

#[ORM\Entity]
#[ORM\Table(name: 'client_profiles')]
class Profile
{
    use EntityIdTrait, TimestampableTrait;

    #[ORM\OneToOne(inversedBy: 'profile', targetEntity: Client::class)]
    #[ORM\JoinColumn(name: 'client_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Client $client;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private string $surname;

    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $personalCode;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $dob;

    public function getFullname(): string
    {
        return $this->getName().' '.$this->getSurname();
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    public function getPersonalCode(): ?string
    {
        return $this->personalCode;
    }

    public function setPersonalCode(?string $personalCode): void
    {
        $this->personalCode = $personalCode;
    }

    public function getDob(): ?\DateTimeInterface
    {
        return $this->dob;
    }

    public function setDob(?\DateTimeInterface $dob): void
    {
        $this->dob = $dob;
    }
}