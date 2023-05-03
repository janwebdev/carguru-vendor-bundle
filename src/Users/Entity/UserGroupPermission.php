<?php

namespace Carguru\VendorBundle\Users\Entity;

use Carguru\VendorBundle\Common\Traits\EntityIdTrait;
use Carguru\VendorBundle\Users\Repository\UserGroupPermissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserGroupPermissionRepository::class)]
#[ORM\Table(name: 'user_group_permissions')]
class UserGroupPermission
{
    use EntityIdTrait;

    #[ORM\Column(type: 'string', length: 255)]
    private string $moduleName;

    #[ORM\Column(type: 'string', length: 255)]
    private string $actionTitle;

    #[ORM\Column(type: 'string', length: 255)]
    private string $controllerPath;

    #[ORM\ManyToMany(targetEntity: UserGroup::class, mappedBy: 'permissions', fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(name: 'user_group_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    #[ORM\JoinTable(name: 'user_groups_and_permissions')]
    private Collection $userGroups;


    public function __construct($moduleName, $actionTitle, $controllerPath)
    {
    	$this->userGroups = new ArrayCollection();
	    $this->moduleName = $moduleName;
	    $this->actionTitle = $actionTitle;
	    $this->controllerPath = $controllerPath;
    }

	public function getModuleName(): string
	{
		return $this->moduleName;
	}

	public function setModuleName(string $moduleName): self
	{
		$this->moduleName = $moduleName;

		return $this;
	}

	public function getActionTitle(): string
	{
		return $this->actionTitle;
	}

	public function setActionTitle(string $actionTitle): self
	{
		$this->actionTitle = $actionTitle;

		return $this;
	}

	public function getControllerPath(): string
	{
		return $this->controllerPath;
	}

	public function setControllerPath(string $controllerPath): self
	{
		$this->controllerPath = $controllerPath;

		return $this;
	}

	public function getUserGroups(): Collection
	{
		return $this->userGroups;
	}

	public function addUserGroup(UserGroup $userGroup): self
	{
		if (!$this->userGroups->contains($userGroup)) {
			$this->userGroups->add($userGroup);
		}
		return $this;
	}

	public function removeUserGroup(UserGroup $userGroup): self
	{
		if ($this->userGroups->contains($userGroup)) {
			$this->userGroups->removeElement($userGroup);
		}
		return $this;
	}
}
