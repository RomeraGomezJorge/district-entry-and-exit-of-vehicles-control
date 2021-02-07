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
		string $username,
		string $name,
		string $surname,
		string $email,
		string $role_id,
		int $isActive,
		string $trafficPoliceBooth_id
	): void {
        $email = new UserEmail( trim( $email ) );
		
		$user = $this->finder->__invoke($id);
		
		$role = $this->roleFinder->__invoke($role_id);
		
		$trafficPoliceBooth = $this->trafficPoliceBoothFinder->__invoke($trafficPoliceBooth_id);
		
		if ($this->hasUserNameChanged($username, $user)) {
            $user->setUsername( trim( $username ), $this->uniqueUserNameSpecification );
		}
		
		if ($this->hasNameChanged($name, $user)) {
            $user->setName( trim( $name ) );
		}
		
		if ($this->hasSurnameChanged($surname, $user)) {
            $user->setSurname( trim( $surname ) );
		}
		
		if ($this->hasEmailChanged($email, $user)) {
			$user->setEmail($email, $this->uniqueUserEmailSpecification);
		}
		
		if ($this->hasRoleChanged($role, $user)) {
			$user->setRole($role);
		}
		
		if ($this->hasTrafficPoliceBoothChanged($trafficPoliceBooth, $user)) {
			$user->setTrafficPoliceBooth($trafficPoliceBooth);
		}
		
		if ($this->hasIsActiveChanged($isActive, $user)) {
			$user->setIsActive($isActive);
		}
		
		$user->setUpdateAt(new \DateTime());
		
		$this->repository->save($user);
	}
	
	private function hasUserNameChanged(string $newUserName, User $user): bool
	{
        return !StringUtils::equals( $newUserName, $user->getUsername() );
	}
	
	private function hasNameChanged(string $newName, User $user): bool
	{
        return !StringUtils::equals( $newName, $user->getName() );
	}
	
	private function hasSurnameChanged(string $newSurname, User $user): bool
	{
        return !StringUtils::equals( $newSurname, $user->getSurname() );
	}
	
	private function hasEmailChanged(UserEmail $newEmail, User $user): bool
	{
        return !StringUtils::equals( $newEmail->value(), $user->getEmail() );
	}
	
	private function hasRoleChanged(Role $newRole, User $user): bool
	{
        return !StringUtils::equals( $newRole->getId(), $user->getRole()->getId() );
	}
	
	private function hasTrafficPoliceBoothChanged(TrafficPoliceBooth $newTrafficPoliceBooth, User $user): bool
	{
        return !StringUtils::equals( $newTrafficPoliceBooth->getId(), $user->getTrafficPoliceBooth()->getId() );
	}
	
	private function hasIsActiveChanged(int $newStatus, User $user): bool
	{
		return $newStatus != $user->getIsActive() ? true : false;
	}
}