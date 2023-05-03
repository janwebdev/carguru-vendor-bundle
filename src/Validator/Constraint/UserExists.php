<?php

namespace Carguru\VendorBundle\Validator\Constraint;

use Carguru\VendorBundle\Validator\UserExistsValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
final class UserExists extends Constraint
{
	public string $messageNotFound = 'Email address "%email%" is not recognized as existing account';
	public string $messageDisabled = "Your account is disabled";

	public function validatedBy(): string
	{
		return UserExistsValidator::class;
	}
}