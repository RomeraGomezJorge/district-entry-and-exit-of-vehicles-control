<?php
	
	namespace App\Backoffice\User\Domain;
	
	
	use App\Backoffice\Role\Domain\Role;
	use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBooth;
	use App\Backoffice\User\Domain\Exception\NonUniqueUserEmail;
	use App\Backoffice\User\Domain\Exception\NonUniqueUserName;
	use App\Shared\Domain\Aggregate\AggregateRoot;
	use App\Shared\Domain\ValueObject\Uuid;
	use DateTime;
	use Symfony\Component\Security\Core\User\UserInterface;
	
	class User extends AggregateRoot implements UserInterface, \Serializable
	{
		private $id;
		private $username;
		private $name;
		private $surname;
		private $email;
		private $password;
		private $role;
		private $isActive;
		private $createAt;
		private $updateAt;
		private $trafficPoliceBooth;
		
		public static function create(
			Uuid $id,
			string $username,
			string $name,
			string $surname,
			UserEmail $email,
			UserPassword $password,
			Role $role,
			int $isActive,
			TrafficPoliceBooth $trafficPoliceBooth,
			DateTime $createAt,
			UniqueUserNameSpecification $uniqueUserNameSpecification,
			UniqueUserEmailSpecification $uniqueUserEmailSpecification
		): self {
			
			if (!$uniqueUserNameSpecification->isSatisfiedBy($username)) {
				throw new NonUniqueUserName($username);
			}
			
			if (!$uniqueUserEmailSpecification->isSatisfiedBy($email->value())) {
				throw new NonUniqueUserEmail($email->value());
			}
			
			$user = new self();
			$user->id = $id->value();
			$user->username = $username;
			$user->name = $name;
			$user->surname = $surname;
			$user->email = $email->value();
			$user->password = $password->value();
			$user->role = $role;
			$user->isActive = (bool)$isActive;
			$user->trafficPoliceBooth = $trafficPoliceBooth;
			$user->createAt = $createAt;
			
			$user->record(new UserCreatedDomainEvent($id->value(), $username, $name, $surname, $email->value(), $password->value(), $role->getId(), $isActive, $trafficPoliceBooth->getId()));
			
			return $user;
		}
		
		public function getId(): String
		{
			return $this->id;
		}
		
		public function getUsername(): string
		{
			return $this->username;
		}
		
		public function getName(): string
		{
			return $this->name;
		}
		
		public function getSurname(): string
		{
			return $this->surname;
		}
		
		public function getEmail(): string
		{
			return $this->email;
		}
		
		public function getPassword(): string
		{
			return $this->password;
		}
		
		public function getRole(): Role
		{
			return $this->role;
		}
		
		public function getIsActive(): int
		{
			return $this->isActive;
		}
		
		public function getTrafficPoliceBooth(): TrafficPoliceBooth
		{
			return $this->trafficPoliceBooth;
		}
		public function getCreateAt()
		{
			return $this->createAt;
		}
		
		public function getUpdateAt()
		{
			return $this->updateAt;
		}
		
		public function setId(Uuid $id): void
		{
			$this->id = $id;
		}
		
		public function setUsername(
			string $username,
			UniqueUserNameSpecification $uniqueUserNameSpecification
		): void {
			
			if (!$uniqueUserNameSpecification->isSatisfiedBy($username)) {
				throw new NonUniqueUserName($username);
			}
			
			$this->username = $username;
		}
		
		public function setName(string $name): void
		{
			$this->name = $name;
		}
		
		public function setSurname(string $surname): void
		{
			$this->surname = $surname;
		}
		
		public function setEmail(UserEmail $email, UniqueUserEmailSpecification $uniqueUserEmailSpecification): void
		{
			if (!$uniqueUserEmailSpecification->isSatisfiedBy($email->value())) {
				throw new NonUniqueUserEmail($email->value());
			}
			$this->email = $email->value();
		}
		
		public function setPassword( UserPassword $password): void
		{
			$this->password = $password->value();
		}
		
		public function setEncodedPassword( string $encodedPassword): void
		{
			$this->password = $encodedPassword;
		}
		
		public function setRole(Role $role): void
		{
			$this->role = $role;
		}
		
		public function setIsActive(int $isActive): void
		{
			$this->isActive = $isActive;
		}
		
		public function setTrafficPoliceBooth(TrafficPoliceBooth $trafficPoliceBooth )
		{
			$this->trafficPoliceBooth = $trafficPoliceBooth;
		}
		public function setUpdateAt(DateTime $updateAt): void
		{
			$this->updateAt = $updateAt;
		}
		
		public function getRoles():array
		{
			return array($this->role->getId());
		}
		
		public function getSalt()
		{
			return null;
		}
		
		public function eraseCredentials()
		{
			/*
			 *  meant to clean up possibly stored plain text passwords (or similar credentials).
			 *  Be careful what to erase if your user class is also mapped to a database as the
			 *  modified object will likely be persisted during the request.
			 */
		}
		
		public function serialize()
		{
			return serialize([
				$this->id,
				$this->username,
				$this->password,
				$this->isActive
			]);
		}
		
		public function unserialize($serialized)
		{
			list($this->id,
				$this->username,
				$this->password,
				$this->isActive
				) = unserialize($serialized);
		}
	}
