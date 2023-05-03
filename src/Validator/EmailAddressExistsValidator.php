<?php

namespace Carguru\VendorBundle\Validator;

use Carguru\VendorBundle\Domain\Users\User;
use Carguru\VendorBundle\Validator\Constraint\EmailAddressExists;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class EmailAddressExistsValidator extends ConstraintValidator
{
	private EntityManagerInterface $em;

	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}

	public function validate($value, Constraint $constraint): void
	{
		if (!$value) return;

        if (!$constraint instanceof EmailAddressExists) {
            throw new UnexpectedTypeException($constraint, EmailAddressExists::class);
        }

		/** @var User $user */
		$user = $this->em->getRepository(User::class)->findOneByEmail($value);
		if (null !== $user) {
			$this->context->buildViolation($constraint->messageFound)
				->setParameter('%email%', $value)
				->addViolation();
		}
	}
}