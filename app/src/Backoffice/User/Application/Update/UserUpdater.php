<?php namespace App\Backoffice\User\Application\Update;

use App\Backoffice\Role\Application\Find\RoleFinder;
use App\Backoffice\Role\Domain\Role;
use App\Backoffice\Role\Domain\RoleRepository;
use App\Backoffice\TrafficPoliceBooth\Application\Find\TrafficPoliceBoothFinder;
use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBooth;
use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBoothRepository;
use App\Backoffice\User\Domain\UniqueUserEmailSpecification;
use App\Backoffice\User\Domain\UniqueUserNameSpecification;
use App\Backoffice\User\Application\Find\UserFinder;
use App\Backoffice\User\Domain\User;
use App\Backoffice\User\Domain\UserEmail;
use App\Backoffice\User\Domain\UserRepository;
use App\Shared\Infrastructure\Utils\StringUtils;

final class UserUpdater
{
	private UserRepository $repository;
	private UserFinder  $finder;
	private UniqueUserNameSpecification $uniqueUserNameSpecification;
	private UniqueUserEmailSpecification $uniqueUserEmailSpecification;
	private RoleFinder $roleFinder;
	private TrafficPoliceBoothFinder $trafficPoliceBoothFinder;
	
	public function __construct(
		UserRepository $repository,
		RoleRepository $roleRepository,
		TrafficPoliceBoothRepository $trafficPoliceBoothRepository,
		UniqueUserNameSpecification $uniqueUserNameSpecification,
		UniqueUserEmailSpecification $uniqueUserEmailSpecification
	) {
		$this->repository = $repository;
		$this->finder = new UserFinder($repository);
		$this->roleFinder = new RoleFinder($roleRepository);
		$this->trafficPoliceBoothFinder = new TrafficPoliceBoothFinder($trafficPoliceBoothRepository);
		$this->uniqueUserNameSpecification = $uniqueUserNameSpecification;
		$this->uniqueUserEmailSpecification = $uniqueUserEmailSpecification;
	}
	
	public function __invoke(
		string $id,
		string $newUsername,
		string $newName,
		string $newSurname,
		string $newEmail,
		string $role_id,
		int $isActive,
		string $trafficPoliceBooth_id
	): void {
		$newEmail = new UserEmail(trim($newEmail));
		
		$user = $this->finder->__invoke($id);
		
		$newRole = $this->roleFinder->__invoke($role_id);
		
		$trafficPoliceBooth = $this->trafficPoliceBoothFinder->__invoke($trafficPoliceBooth_id);
		
		$user->changeUsername(trim($newUsername), $this->uniqueUserNameSpecification);
		
		$user->changeName(trim($newName));
		
		$user->changeSurname(trim($newSurname));
		
		$user->changeEmail($newEmail, $this->uniqueUserEmailSpecification);
		
		$user->changeRole($newRole);
		
		$user->changeTrafficPoliceBooth($trafficPoliceBooth);
		
		$user->changeIsActive($isActive);
		
		$user->setUpdateAt(new \DateTime());
		
		$this->repository->save($user);
	}
}