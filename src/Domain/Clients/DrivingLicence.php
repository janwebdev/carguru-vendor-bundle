<?php

namespace Carguru\VendorBundle\Domain\Clients;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Carguru\VendorBundle\Traits\EntityIdTrait;
use Carguru\VendorBundle\Traits\TimestampableTrait;

#[ORM\Entity]
#[ORM\Table(name: 'client_driving_licences')]
class DrivingLicence
{
    use EntityIdTrait, TimestampableTrait;

    #[ORM\OneToOne(inversedBy: 'drivingLicence', targetEntity: Client::class)]
    #[ORM\JoinColumn(name: 'client_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Client $client;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $documentNumber;

    #[ORM\Column(name: 'is_approved', type: 'boolean', options: ["default"=>"false"])]
    private bool $isApproved = false;

    #[ORM\Column(name: 'is_approved_by_registry', type: 'boolean', options: ["default"=>"false"])]
    private bool $isApprovedByRegistry = false;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $registryCheckupAt;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $termsOfUse;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: DrivingLicenceImage::class, cascade: ["persist", "remove"], fetch: 'EXTRA_LAZY')]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    public function getDocumentNumber(): ?string
    {
        return $this->documentNumber;
    }

    public function setDocumentNumber(?string $documentNumber): void
    {
        $this->documentNumber = $documentNumber;
    }

    public function isApproved(): bool
    {
        return $this->isApproved;
    }

    public function setIsApproved(bool $isApproved): void
    {
        $this->isApproved = $isApproved;
    }

    public function isApprovedByRegistry(): bool
    {
        return $this->isApprovedByRegistry;
    }

    public function setIsApprovedByRegistry(bool $isApprovedByRegistry): void
    {
        $this->isApprovedByRegistry = $isApprovedByRegistry;
    }

    public function getRegistryCheckupAt(): ?\DateTimeInterface
    {
        return $this->registryCheckupAt;
    }

    public function setRegistryCheckupAt(?\DateTimeInterface $registryCheckupAt): void
    {
        $this->registryCheckupAt = $registryCheckupAt;
    }

    public function getTermsOfUse(): ?\DateTimeInterface
    {
        return $this->termsOfUse;
    }

    public function setTermsOfUse(?\DateTimeInterface $termsOfUse): void
    {
        $this->termsOfUse = $termsOfUse;
    }

    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(DrivingLicenceImage $image): void
    {
        if (!$this->images->contains($image)) {
            $image->setImage($this);
            $this->images->add($image);
        }
    }

    public function removeImage(DrivingLicenceImage $image): void
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
        }
    }

}