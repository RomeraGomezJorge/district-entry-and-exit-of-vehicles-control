<?php
	
	namespace App\Backoffice\User\Application\Create;
	
	use App\Backoffice\Role\Application\Find\RoleFinder;
	use App\Backoffice\Role\Domain\RoleRepository;
	use App\Backoffice\TrafficPoliceBooth\Application\Find\TrafficPoliceBoothFinder;
	use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBoothRepository;
	use App\Backoffice\User\Domain\UserPassword;
	use App\Backoffice\User\Domain\PasswordEncoder;
	use App\Backoffice\User\Domain\UserEmail;
	use App\Shared\Domain\Bus\Event\EventBus;
	use App\Backoffice\User\Domain\User;
	use App\Backoffice\User\Domain\UserRepository;
	use App\Backoffice\User\Domain\UniqueUserNameSpecification;
	use App\Backoffice\User\Domain\UniqueUserEmailSpecification;
	use App\Shared\Domain\ValueObject\Uuid;
	
	
	final class UserCreator
	{
		private UserRepository $repository;
		private UniqueUserNameSpecification $uniqueUserNameSpecification;
		private UniqueUserEmailSpecification $uniqueUserEmailSpecification;
		private EventBus $bus;
		private PasswordEncoder $passwordEncoder;
		private RoleFinder $finderRole;
		private TrafficPoliceBoothFinder $finderTrafficPoliceBooth;
		
		public function __construct(
			UserRepository $repository,
			RoleRepository $roleRepository,
			TrafficPoliceBoothRepository $trafficPoliceBoothRepository,
			UniqueUserNameSpecification $uniqueUserNameSpecification,
			UniqueUserEmailSpecification $uniqueUserEmailSpecification,
			PasswordEncoder $passwordEncoder,
			EventBus $bus
		) {
			$this->repository = $repository;
			$this->finderRole = new RoleFinder($roleRepository);
			$this->finderTrafficPoliceBooth = new TrafficPoliceBoothFinder($trafficPoliceBoothRepository);
			$this->uniqueUserNameSpecification = $uniqueUserNameSpecification;
			$this->uniqueUserEmailSpecification = $uniqueUserEmailSpecification;
			$this->passwordEncoder = $passwordEncoder;
			$this->bus = $bus;
		}
		
		public function __invoke(
			string $id,
			string $username,
			string $name,
			string $surname,
			string $email,
			string $plainPassword,
			string $role_id,
			int $isActive,
			string $trafficPoliceBooth_id
		) {
			$id = new Uuid($id);
			
			$email = new UserEmail($email);
			
			$plainPassword = new UserPassword($plainPassword);
			
			$role = $this->finderRole->__invoke($role_id);

			$trafficPoliceBooth = $this->finderTrafficPoliceBooth->__invoke($trafficPoliceBooth_id);

			$createAt = new \DateTime();
			
			$user = User::create(
				$id,
				$username,
				$name,
				$surname,
				$email,
				$plainPassword,
				$role,
				$isActive,
				$trafficPoliceBooth,
				$createAt,
				$this->uniqueUserNameSpecification,
				$this->uniqueUserEmailSpecification);
			
			$user->setEncodedPassword(
				$this->passwordEncoder->encode($user, $plainPassword->value())
			);
			
			$this->repository->save($user);
			
			$this->bus->publish(...$user->pullDomainEvents());
		}
	}