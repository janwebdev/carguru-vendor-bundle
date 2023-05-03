<?php

namespace Carguru\VendorBundle\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

trait AdvancedUserInterfaceTrait
{
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
	private ?string $passwordRecoveredHash = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
	private ?\DateTimeImmutable $passwordRecoveredAt = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
	private ?\DateTimeImmutable $lastLoginAt = null;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
	private ?string $lastLoginIp = null;

	public function isEqualTo(UserInterface $userInterface): bool
	{
		return $this->getId() === $userInterface->getId();
	}

	public function serialize(): string
	{
		return serialize([$this->id, $this->email, $this->password]);
	}

	public function unserialize($serialized): void
	{
		[$this->id, $this->email, $this->password] = unserialize($serialized, ['allowed_classes' => false]);
	}

	public function getPasswordRecoveredHash(): ?string
	{
		return $this->passwordRecoveredHash;
	}

	public function getPasswordRecoveredAt(): ?\DateTimeImmutable
	{
		return $this->passwordRecoveredAt;
	}

	public function getLastLoginAt(): ?\DateTimeImmutable
	{
		return $this->lastLoginAt;
	}

	public function getLastLoginIp(): ?string
	{
		return $this->lastLoginIp;
	}

	public function setAccountLocked(bool $accountLocked): void
	{
		$this->accountLocked = $accountLocked;
	}

	public function setPasswordRecoveredHash(?string $passwordRecoveredHash): void
	{
		$this->passwordRecoveredHash = $passwordRecoveredHash;
	}

	public function setPasswordRecoveredAt(?\DateTimeImmutable $passwordRecoveredAt): void
	{
		$this->passwordRecoveredAt = $passwordRecoveredAt;
	}

	public function setLastLoginAt(?\DateTimeImmutable $lastLoginAt): void
	{
		$this->lastLoginAt = $lastLoginAt;
	}

	public function setLastLoginIp(?string $lastLoginIp): void
	{
		$this->lastLoginIp = $lastLoginIp;
	}
}