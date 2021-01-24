<?php
	
	
	namespace App\Backoffice\TrafficPoliceBooth\Domain;
	
	interface UniqueTrafficPoliceBoothDescriptionSpecification
	{
		public function isSatisfiedBy( string $description): bool;
	}