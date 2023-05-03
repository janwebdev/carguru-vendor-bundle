<?php

namespace Carguru\VendorBundle\Repository\Users;

use Carguru\VendorBundle\Domain\Users\UserGroup;
use Carguru\VendorBundle\Domain\Users\UserGroupPermission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserGroup[]    findAll()
 * @method UserGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserGroup::class);
    }

	public function findAllByIds(array $ids)
	{
		return $this->createQueryBuilder('ug')
			->andWhere('ug.id IN (:ids)')
			->setParameter('ids', $ids)
			->getQuery()
			->getResult()
			;
    }

	public function getAllPermissionsAsArray(): array
	{
		$results = $this->createQueryBuilder('ug')
			->select('ug,ugp')
			->addCriteria(self::getActiveUserGroupsCriteria())
			->leftJoin('ug.permissions', 'ugp')
			->addOrderBy('ug.name')
			->getQuery()
			->getResult()
		;

		$permissions = [];
		/** @var UserGroup $group */
		foreach($results as $group) {

			/** @var UserGroupPermission $permission */
			foreach($group->getPermissions() as $permission) {
				$permissions[$group->getName()][$permission->getModuleName()][] = $permission->getControllerPath();
			}
		}

		return $permissions;
    }

	public static function getActiveUserGroupsCriteria(): Criteria
	{
		return Criteria::create()->andWhere(Criteria::expr()->eq('enabled', true));
	}

	public function getActiveUserGroupsQuery(): Query
	{
		return $this->createQueryBuilder('ug')
			->addCriteria(self::getActiveUserGroupsCriteria())
			->addOrderBy('ug.name')
			->getQuery()
			;
	}
}
