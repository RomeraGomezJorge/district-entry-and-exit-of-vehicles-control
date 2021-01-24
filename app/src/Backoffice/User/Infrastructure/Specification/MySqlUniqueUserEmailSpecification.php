<?php
	
	declare(strict_types=1);
	
	namespace App\Backoffice\User\Infrastructure\Specification;
	
	use App\Backoffice\User\Domain\UniqueUserEmailSpecification;
	use App\Backoffice\User\Infrastructure\Persistence\MySqlUserRepository;
	
	final class MySqlUniqueUserEmailSpecification implements UniqueUserEmailSpecification
	{
		private MySqlUserRepository $repository;
		
		public function __construct( MySqlUserRepository $repository)
		{
			$this->repository = $repository;
		}
		
		public function isSatisfiedBy( string $email ): bool
		{
			return !$this->repository->isEmailExits(array('email' => $email));
		}
	}