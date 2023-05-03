<?php

namespace Carguru\VendorBundle\Users\Repository;

use Carguru\VendorBundle\Users\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

	public function getGroupsNamesAsArray(UserInterface $user): array
	{
		$groups = [];
		foreach($user->getActiveUserGroups() as $group) {
			$groups[] = $group->getName();
		}
		return $groups;
    }

    public function existsByPasswordToken(string $token): bool
    {
        $object = $this->createQueryBuilder('u')
            ->andWhere('u.passwordRecoveredHash = :hash')
            ->setParameter('hash', $token)
            ->getQuery()
            ->getOneOrNullResult()
            ;

        if(!$object) {
            return false;
        }
        return true;
    }

    public function getUsersQuery(): Query
    {
        return $this->createQueryBuilder('u')
            ->getQuery()
            ;
    }

	public static function getActiveUsersCriteria(): Criteria
	{
		return Criteria::create()->andWhere(Criteria::expr()->eq('enabled', true));
	}

	public function getActiveUsersQuery(): Query
	{
		return $this->createQueryBuilder('u')
			->addCriteria(self::getActiveUsersCriteria())
			->getQuery()
			;
	}
}