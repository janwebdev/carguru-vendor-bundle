<?php

namespace Carguru\VendorBundle\Users\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use App\Users\Validator\EmailAddressExistsValidator;

#[\Attribute]
final class EmailAddressExists extends Constraint
{
	public string $messageFound = 'Email address "%email%" is an existing account';

	public function validatedBy(): string
	{
		return EmailAddressExistsValidator::class;
	}
}