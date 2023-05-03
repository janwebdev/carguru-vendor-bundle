<?php

namespace Carguru\VendorBundle\Users\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use App\Users\Validator\UserExistsValidator;

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