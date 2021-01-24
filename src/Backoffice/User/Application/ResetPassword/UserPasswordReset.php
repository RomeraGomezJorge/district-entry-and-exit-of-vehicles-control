<?php	namespace App\Backoffice\User\Application\ResetPassword;
	
	use App\Backoffice\Role\Application\Find\RoleFinder;
	use App\Backoffice\Role\Domain\Role;
	use App\Backoffice\Role\Domain\RoleRepository;
	use App\Backoffice\User\Domain\PasswordEncoder;
	use App\Backoffice\User\Domain\UniqueUserEmailSpecification;
	use App\Backoffice\User\Domain\UniqueUserNameSpecification;
	use App\Backoffice\User\Application\Find\UserFinder;
	use App\Backoffice\User\Domain\User;
	use App\Backoffice\User\Domain\UserEmail;
	use App\Backoffice\User\Domain\UserPassword;
	use App\Backoffice\User\Domain\UserRepository;
	
	
	final class UserPasswordReset
	{
		private UserRepository $repository;
		private UserFinder  $finder;
		private PasswordEncoder $passwordEncoder;
		
		public function __construct(UserRepository $repository, PasswordEncoder $passwordEncoder) {
			$this->repository = $repository;
			$this->finder = new UserFinder($repository);
			$this->passwordEncoder = $passwordEncoder;
		}
		
		public function __invoke(string $id, string $plainPassword)
		{
			$plainPassword = new UserPassword($plainPassword);
			
			$user = $this->finder->__invoke($id);
			
			$encodedPassword = $this->passwordEncoder->encode($user,$plainPassword);
			
            $user->setEncodedPassword($encodedPassword);
            
			$user->setUpdateAt(new \DateTime());
			
            $this->repository->save($user);
		}
        

    }