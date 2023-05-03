<?php

namespace Carguru\VendorBundle\Domain\Users;

use Carguru\VendorBundle\Repository\Users\UserGroupRepository;
use Carguru\VendorBundle\Repository\Users\UserRepository;
use Carguru\VendorBundle\Traits\EnabledTrait;
use Carguru\VendorBundle\Traits\EntityIdTrait;
use Carguru\VendorBundle\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserGroupRepository::class)]
#[ORM\Table(name: 'user_groups')]
class UserGroup implements \Stringable
{
	use EntityIdTrait, EnabledTrait, TimestampableTrait;

	public const GROUPS_SESSION_KEY = 'user_groups';

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(groups: ["Form"])]
    private string $name;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'userGroups', fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    #[ORM\JoinTable(name: 'users_in_groups')]
    private Collection $users;

    #[ORM\ManyToMany(targetEntity: UserGroupPermission::class, inversedBy: 'userGroups', cascade: ["persist"], fetch: 'EXTRA_LAZY')]
    #[ORM\OrderBy(['moduleName' => 'ASC'])]
    private Collection $permissions;

    public function __construct()
    {
    	$this->users = new ArrayCollection();
    	$this->permissions = new ArrayCollection();
    }

    public function __toString(): string
    {
    	return $this->name;
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

	public function getActiveUsers(): Collection
	{
		return $this->users->matching(UserRepository::getActiveUsersCriteria());
	}

	public function getUsers(): Collection
	{
		return $this->users;
	}

	public function addUser(User $user): self
	{
		if (!$this->users->contains($user)) {
			$this->users->add($user);
		}
		return $this;
	}

	public function removeUser(User $user): self
	{
		if ($this->users->contains($user)) {
			$this->users->removeElement($user);
		}
		return $this;
	}

	public function getPermissions(): Collection
	{
		return $this->permissions;
	}

	public function addPermission(UserGroupPermission $permission): self
	{
		if (!$this->permissions->contains($permission)) {
			$permission->addUserGroup($this);
			$this->permissions->add($permission);
		}
		return $this;
	}

	public function removePermission(UserGroupPermission $permission): self
	{
		if ($this->permissions->contains($permission)) {
			$permission->removeUserGroup($this);
			$this->permissions->removeElement($permission);
		}
		return $this;
	}
}
