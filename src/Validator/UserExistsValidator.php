<?php

namespace Carguru\VendorBundle\Validator;

use Carguru\VendorBundle\Domain\Users\User;
use Carguru\VendorBundle\Validator\Constraint\UserExists;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UserExistsValidator extends ConstraintValidator
{
	private EntityManagerInterface $em;

	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}

	public function validate($value, Constraint $constraint): void
	{
		if (!$value) return;

        if (!$constraint instanceof UserExists) {
            throw new UnexpectedTypeException($constraint, UserExists::class);
        }

		/** @var User $user */
		$user = $this->em->getRepository(User::class)->findOneByEmail($value);
		if (null === $user) {
			$this->context->buildViolation($constraint->messageNotFound)
				->setParameter('%email%', $value)
				->addViolation();
		} else {
		    if (!$user->isEnabled()) {
                $this->context->buildViolation($constraint->messageDisabled)
                    ->addViolation();
            }
		}
	}
}