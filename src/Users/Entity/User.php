<?php

namespace Carguru\VendorBundle\Users\Entity;

use Carguru\VendorBundle\Common\Contract\CommunicationInterface;
use Carguru\VendorBundle\Common\Contract\SuperAdminInterface;
use Carguru\VendorBundle\Common\Traits\EntityIdTrait;
use Carguru\VendorBundle\Users\Repository\UserGroupRepository;
use Carguru\VendorBundle\Users\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Carguru\VendorBundle\Common\Traits\EnabledTrait;
use Carguru\VendorBundle\Common\Traits\AdvancedUserInterfaceTrait;
use Carguru\VendorBundle\Common\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Users\Validator\Constraint as UserConstraint;
use App\Common\Validator\Constraint as CommonConstraint;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
#[ORM\Index(fields: ["passwordRecoveredHash"], name: 'user_pass_rec_hash_idx')]
#[Assert\GroupSequence(["User", "Form", "PasswordRecovery", "Password", "Registration"])]
#[UniqueEntity("email")]
#[Vich\Uploadable]
class User implements UserInterface, SuperAdminInterface, CommunicationInterface, EquatableInterface, \Serializable, \Stringable, PasswordAuthenticatedUserInterface
{
    use EntityIdTrait,
        EnabledTrait,
        TimestampableTrait,
        AdvancedUserInterfaceTrait;

    public static $imageFilter = "user_avatar";

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(groups: ["Form","Registration"])]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(groups: ["Form","Registration"])]
    private ?string $surname = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\NotBlank(groups: ["Form","PasswordRecovery","Registration"])]
    #[Assert\Email(groups: ["Form","PasswordRecovery","Registration"])]
    #[UserConstraint\UserExists(groups: ["PasswordRecovery"])]
    #[UserConstraint\EmailAddressExists(groups: ["Form","Registration"])]
    private string $email;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\NotBlank(groups: ["Form","Registration"])]
    #[Assert\Regex(pattern: "/^[0-9]*$/", groups: ["Form","Registration"])]
    private ?string $phone = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\NotBlank(groups: ["Form"])]
	private ?string $position = null;

    #[ORM\Column(type: 'string')]
    private string $password;

    #[Assert\NotBlank(groups: ["Password","Registration"])]
    #[CommonConstraint\Password(groups: ["Password","Registration"])]
    private ?string $plainPassword = null;

    #[ORM\Column(type: 'json', nullable: true, options: ['jsonb'=>true])]
    private array $roles;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $image;

    //NOTE: This is not a mapped field of entity metadata, just a simple property.
    #[Vich\UploadableField(mapping: 'admins', fileNameProperty: 'image')]
    #[Assert\Image(mimeTypes: ["image/jpeg","image/png","image/gif","image/webp"], mimeTypesMessage: 'The format of file is wrong. It is allowed only .jpg, .jpeg, .png, .gif, .webp files', groups: ["UserAvatar"])]
    #[Assert\File(groups: ["UserAvatar"])]
    #[Assert\Type(type: UploadedFile::class, groups: ["new","edit"])]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'boolean', options: ['default'=>'false'])]
    private bool $isSuperAdmin = false;

    #[ORM\ManyToMany(targetEntity: UserGroup::class, mappedBy: 'users', cascade: ["persist"], fetch: 'EXTRA_LAZY')]
    #[ORM\OrderBy(['name' => 'ASC'])]
    private Collection $userGroups;

	public function __construct()
	{
		$this->userGroups = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getFullName();
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $image = null): self
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable;
        }

        return $this;
    }

	public function isAdmin(): bool
	{
		return in_array(self::ROLE_ADMIN, $this->getRoles(), true);
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        // guarantees that a user always has at least one role for security
        if (empty($roles)) {
            $roles[] = self::ROLE_ADMIN;
        }

        return array_unique($roles);
    }

    public function setRoles(?array $roles = null): self
    {
    	if (!$roles) {
    		$roles = [self::ROLE_ADMIN];
	    }
        $this->roles = $roles;

        return $this;
    }

    /**
     * Removes sensitive data from the user.
     *
     * {@inheritdoc}
     */
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    public function getFullName(): string
    {
        return ucfirst($this->name).' '.ucfirst($this->surname);
    }

    public function getInitials(): string
    {
        return mb_strtoupper($this->name)[0].mb_strtoupper($this->surname)[0];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

	public function getPosition(): ?string
	{
		return $this->position;
	}

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

	    return $this;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

	    return $this;
    }

	public function setPosition(?string $position): self
	{
		$this->position = $position;

		return $this;
	}

    public function setPassword(string $password): self
    {
        $this->password = $password;

	    return $this;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

	    return $this;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

	    return $this;
    }

	public function isSuperAdmin(): bool
	{
		return $this->isSuperAdmin === true;
	}

	public function setIsSuperAdmin(bool $isSuperAdmin): self
	{
		$this->isSuperAdmin = $isSuperAdmin;

		return $this;
	}

	public function getActiveUserGroupsFilterExample(): Collection
	{
		return $this->userGroups->filter(function(UserGroup $entity) {
			return $entity->isEnabled() === true;
		});
	}

	public function getActiveUserGroups(): Collection
	{
		return $this->userGroups->matching(UserGroupRepository::getActiveUserGroupsCriteria());
	}

	public function getUserGroups(): Collection
	{
		return $this->userGroups;
	}

	public function addUserGroup(UserGroup $userGroup): self
	{
		if (!$this->userGroups->contains($userGroup)) {
			$userGroup->addUser($this);
			$this->userGroups->add($userGroup);
		}
		return $this;
	}

	public function removeUserGroup(UserGroup $userGroup): self
	{
		if ($this->userGroups->contains($userGroup)) {
			$userGroup->removeUser($this);
			$this->userGroups->removeElement($userGroup);
		}
		return $this;
	}

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}
