<?php
	
	
	namespace App\Backoffice\User\Domain;
	
	interface UniqueUserEmailSpecification
	{
		public function isSatisfiedBy( string $fullName): bool;
	}