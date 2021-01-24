<?php
	declare(strict_types=1);
	
	namespace App\Backoffice\IdentityCardType\Domain\Exception;
	
	use App\Shared\Domain\DomainError;
	
	final class NonUniqueIdentityCardTypeDescription extends DomainError
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
			return sprintf('El tipo de documento con la descripción "%s" que ha ingresado ya está registrada.',
				$this->description);
		}
	}