<?php
	declare(strict_types=1);
	
	namespace App\Backoffice\TrafficPoliceBooth\Domain\Exception;
	
	use App\Shared\Domain\DomainError;
	
	final class NonUniqueTrafficPoliceBoothDescription extends DomainError
	{
		private string $description;
		
		public function __construct(string $description)
		{
			$this->description = $description;
			
			parent::__construct();
		}
		
		public function errorCode(): string
		{
			return 'description_already_exists';
		}
		
		protected function errorMessage(): string
		{
			return sprintf('El tag con la descripción "%s" que ha ingresado ya está registrada.', $this->description);
		}
	}