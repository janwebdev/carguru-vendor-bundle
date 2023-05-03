<?php

namespace Carguru\VendorBundle\Users\Repository;

use Carguru\VendorBundle\Users\Entity\UserGroup;
use Carguru\VendorBundle\Users\Entity\UserGroupPermission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserGroupPermission|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserGroupPermission|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserGroupPermission[]    findAll()
 * @method UserGroupPermission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserGroupPermissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserGroupPermission::class);
    }

    public function getAllAsModuleControllerActionArray(): array
    {
	    $results = $this->createQueryBuilder('ugp')
		    ->getQuery()
		    ->getResult()
	    ;
	    $permissions = [];
	    /** @var UserGroupPermission $permission */
	    foreach($results as $permission) {
		    $permissions[$permission->getModuleName()][] = $permission->getControllerPath();
	    }
	    return $permissions;

    }

	public function getGroupPermissionsAsArrayByGroup(UserGroup $group): array
	{
		$results = $this->createQueryBuilder('ugp')
			->select('ugp, ug')
			->leftJoin('ugp.userGroups', 'ug')
			->andWhere('ug = :group')
			->setParameter('group', $group)
			->getQuery()
			->getResult()
			;

		$permissions = [];
		/** @var UserGroupPermission $permission */
		foreach($results as $permission) {
			$permissions[$permission->getModuleName()][] = $permission->getActionTitle();
		}
		return $permissions;
    }
}
