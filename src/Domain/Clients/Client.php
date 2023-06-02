<?php

namespace Carguru\VendorBundle\Domain\Clients;

use Carguru\VendorBundle\Model\ClientStatus;
use Carguru\VendorBundle\Repository\Clients\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Carguru\VendorBundle\Traits\EntityIdTrait;
use Carguru\VendorBundle\Traits\TimestampableTrait;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ORM\Table(name: 'clients')]
class Client implements \Stringable
{
    use EntityIdTrait, TimestampableTrait;

    #[ORM\Column(type: 'string', length: 255)]
    private string $firebaseId;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private string $phone;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $password;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $email;

    #[ORM\Column(type: 'string', length: 5, nullable: true)]
    private string $verificationCode;

    #[ORM\Column(type: 'string', length: 5, nullable: true)]
    private string $emailVerificationCode;

    #[ORM\Column(name: 'accepted_age_limit', type: 'boolean', options: ["default"=>"false"])]
    private bool $acceptedAgeLimit = false;

    #[ORM\Column(name: 'accepted_driving_experience', type: 'boolean', options: ["default"=>"false"])]
    private bool $acceptedDrivingExp = false;

    #[ORM\Column(name: 'accepted_terms', type: 'boolean', options: ["default"=>"false"])]
    private bool $acceptedTerms = false;

    #[ORM\Column(name: 'accepted_contract', type: 'boolean', options: ["default"=>"false"])]
    private bool $acceptedContract = false;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $avatar;

    #[ORM\Column(type: 'smallint', length: 1)]
    private int $status = ClientStatus::STATUS_REGISTRATION;

    #[ORM\Column(type: 'smallint', length: 1, nullable: true)]
    private ?int $statusReason;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $statusComment;

    #[ORM\OneToOne(mappedBy: 'client', targetEntity: Picture::class)]
    private ?Picture $picture = null;

    #[ORM\OneToOne(mappedBy: 'client', targetEntity: DrivingLicence::class)]
    private ?DrivingLicence $drivingLicence = null;

    #[ORM\OneToOne(mappedBy: 'client', targetEntity: Profile::class)]
    private ?Profile $profile = null;

    public function __toString(): string
    {
        return $this->profile ? $this->profile->getFullname() : $this->getId();
    }

    public function getFirebaseId(): string
    {
        return $this->firebaseId;
    }

    public function setFirebaseId(string $firebaseId): void
    {
        $this->firebaseId = $firebaseId;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getVerificationCode(): string
    {
        return $this->verificationCode;
    }

    public function setVerificationCode(string $verificationCode): void
    {
        $this->verificationCode = $verificationCode;
    }

    public function getEmailVerificationCode(): string
    {
        return $this->emailVerificationCode;
    }

    public function setEmailVerificationCode(string $emailVerificationCode): void
    {
        $this->emailVerificationCode = $emailVerificationCode;
    }

    public function isAcceptedAgeLimit(): bool
    {
        return $this->acceptedAgeLimit;
    }

    public function setAcceptedAgeLimit(bool $acceptedAgeLimit): void
    {
        $this->acceptedAgeLimit = $acceptedAgeLimit;
    }

    public function isAcceptedDrivingExp(): bool
    {
        return $this->acceptedDrivingExp;
    }

    public function setAcceptedDrivingExp(bool $acceptedDrivingExp): void
    {
        $this->acceptedDrivingExp = $acceptedDrivingExp;
    }

    public function isAcceptedTerms(): bool
    {
        return $this->acceptedTerms;
    }

    public function setAcceptedTerms(bool $acceptedTerms): void
    {
        $this->acceptedTerms = $acceptedTerms;
    }

    /**
     * @return bool
     */
    public function isAcceptedContract(): bool
    {
        return $this->acceptedContract;
    }

    /**
     * @param bool $acceptedContract
     */
    public function setAcceptedContract(bool $acceptedContract): void
    {
        $this->acceptedContract = $acceptedContract;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function getStatusReason(): ?int
    {
        return $this->statusReason;
    }

    public function setStatusReason(?int $statusReason): void
    {
        $this->statusReason = $statusReason;
    }

    public function getStatusComment(): ?string
    {
        return $this->statusComment;
    }

    public function setStatusComment(?string $statusComment): void
    {
        $this->statusComment = $statusComment;
    }

    public function getPicture(): ?Picture
    {
        return $this->picture;
    }

    public function setPicture(?Picture $picture): void
    {
        $this->picture = $picture;
    }

    public function getDrivingLicence(): ?DrivingLicence
    {
        return $this->drivingLicence;
    }

    public function setDrivingLicence(?DrivingLicence $drivingLicence): void
    {
        $this->drivingLicence = $drivingLicence;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): void
    {
        $this->profile = $profile;
    }

}