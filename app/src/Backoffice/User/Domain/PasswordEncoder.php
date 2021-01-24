<?php
	
	
	namespace App\Backoffice\User\Domain;
	
	
	interface PasswordEncoder
	{
		public function encode(User $user, string $plainPassword):string ;
		

//		public function isPasswordValid(UserPassword $anEncoded, $aPlainPassword);
	

	}