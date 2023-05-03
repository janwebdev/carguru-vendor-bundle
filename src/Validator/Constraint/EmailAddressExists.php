<?php

namespace Carguru\VendorBundle\Validator\Constraint;

use Carguru\VendorBundle\Validator\EmailAddressExistsValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
final class EmailAddressExists extends Constraint
{
	public string $messageFound = 'Email address "%email%" is an existing account';

	public function validatedBy(): string
	{
		return EmailAddressExistsValidator::class;
	}
}