<?php
	
	
	namespace App\Backoffice\User\Application\UserNameChecker;
	
	use App\Backoffice\User\Domain\UniqueUserNameSpecification;
	
	final class CheckUserNameAvailability
	{
		private UniqueUserNameSpecification $uniqueUserNameSpecification;
		
		public function __construct( UniqueUserNameSpecification $uniqueUserNameSpecification)
		{
			$this->uniqueUserNameSpecification = $uniqueUserNameSpecification;
		}
		
		public function __invoke(string $username): bool
		{
			return $this->uniqueUserNameSpecification->isSatisfiedBy($username);
		}
	}