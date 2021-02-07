<?php
	
	namespace App\Backoffice\User\Application\EmailChecker;
	
	use App\Backoffice\User\Domain\UniqueUserEmailSpecification;
	
	final class CheckUserEmailAvailability
	{
		private UniqueUserEmailSpecification $uniqueUserEmailSpecification;
		
		public function __construct( UniqueUserEmailSpecification $uniqueUserEmailSpecification)
		{
			$this->uniqueUserEmailSpecification = $uniqueUserEmailSpecification;
		}
		
		public function __invoke(string $username): bool
		{
			return $this->uniqueUserEmailSpecification->isSatisfiedBy(trim($username));
		}
	}