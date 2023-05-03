<?php

namespace Carguru\VendorBundle\Validator;

use Carguru\VendorBundle\Validator\Constraint\Password;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use function mb_strlen;

class PasswordValidator extends ConstraintValidator
{
	public function validate($value, Constraint $constraint): void
	{
		if (!$value) return;

		if (!$constraint instanceof Password) {
			throw new UnexpectedTypeException($constraint, Password::class);
		}

		if(preg_match_all($constraint->r1, $value, $o)<1) {
			$this->context->buildViolation($constraint->noUppercase)
				->addViolation();
		}

		if(preg_match_all($constraint->r2, $value, $o)<3) {
			$this->context->buildViolation($constraint->noLowercase)
				->addViolation();
		}

		if(preg_match_all($constraint->r3, $value, $o)<1) {
			$this->context->buildViolation($constraint->noDigits)
				->addViolation();
		}

		if(mb_strlen($value)<8) {
			$this->context->buildViolation($constraint->tooShort)
				->addViolation();
		}
	}
}