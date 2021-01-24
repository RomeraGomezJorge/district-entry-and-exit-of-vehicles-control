<?php
	
	
	namespace App\Backoffice\IdentityCardType\Domain;
	
	interface UniqueIdentityCardTypeDescriptionSpecification
	{
		public function isSatisfiedBy(string $description): bool;
	}