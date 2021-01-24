<?php
	
	
	namespace App\Backoffice\User\Domain;
	
	interface UniqueUserNameSpecification
	{
		public function isSatisfiedBy( string $username): bool;
	}