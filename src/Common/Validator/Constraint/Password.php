<?php

namespace App\Common\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use App\Common\Validator\PasswordValidator;

#[\Attribute]
final class Password extends Constraint
{
	public string $noUppercase = "The password must contain at least 1 uppercase letter";
	public string $noLowercase = "The password must contain at least 3 lowercase letters";
	public string $noDigits = "The password must contain at least 1 digit";
	public string $tooShort = "The password must be at least 8 symbols long";

	public string $r1='/[A-Z]/';  //Uppercase
	public string $r2='/[a-z]/';  //lowercase
	public string $r3='/[0-9]/';  //numbers

	public function validatedBy(): string
	{
		return PasswordValidator::class;
	}
}