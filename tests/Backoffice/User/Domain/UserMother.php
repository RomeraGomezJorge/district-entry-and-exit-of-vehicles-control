<?php
	
	declare(strict_types=1);
	
	namespace App\Tests\Backoffice\User\Domain;
	
	
	use App\Backoffice\Role\Domain\Role;
	use App\Backoffice\Role\Domain\RoleRepository;
	use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBooth;
	use App\Backoffice\User\Domain\User;
	use App\Backoffice\User\Domain\UniqueUserEmailSpecification;
	use App\Backoffice\User\Domain\UniqueUserNameSpecification;
	use App\Backoffice\User\Domain\UserEmail;
	use App\Backoffice\User\Domain\UserPassword;
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Tests\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBoothMother;
	use App\Tests\Shared\Domain\EmailMother;
	use App\Tests\Shared\Domain\IntegerMother;
	use App\Tests\Shared\Domain\PasswordMother;
	use App\Tests\Shared\Domain\WordMother;
	use PharIo\Manifest\Email;
	use PHPUnit\Framework\TestCase;
	
	
	final class UserMother extends testCase
	{
		public static function create(
			Uuid $id,
			string $username,
			string $name,
			string $surname,
			string $email,
			string $password,
			Role $role,
			int $isActive,
			TrafficPoliceBooth $TrafficPoliceBooth,
			bool $isUserNameInUse,
			bool $isEmailInUse
		): User {
			$uniqueUserNameSpecificationStub = (new UserMother())->uniqueUserNameSpecificationStub();
			
			$uniqueUserNameSpecificationStub->method('isSatisfiedBy')->willReturn($isUserNameInUse);
			
			$uniqueUserEmailSpecificationStub = (new UserMother())->uniqueUserEmailSpecificationStub();
			
			$uniqueUserEmailSpecificationStub->method('isSatisfiedBy')->willReturn($isEmailInUse);
			
			return User::create(
				$id,
				$username,
				$name,
				$surname,
				new UserEmail($email),
				new UserPassword($password),
				$role,
				$isActive,
				$TrafficPoliceBooth,
				new \DateTime(),
				$uniqueUserNameSpecificationStub,
				$uniqueUserEmailSpecificationStub
			);
		}
		
		public static function random(): User
		{
			return self::create(
				$id = Uuid::random(),
				$username = WordMother::random(),
				$name = WordMother::random(),
				$surname = WordMother::random(),
				$email = EmailMother::random(),
				$password = PasswordMother::random(),
				$role = (new UserMother())->createRandomRole(),
				$isActive = IntegerMother::between(0, 1),
				$trafficPoliceBooth = TrafficPoliceBoothMother::random(),
				true,
				true);
		}
		
		public static function randomWithUserName($username): User
		{
			return self::create(
				$id = Uuid::random(),
				$username ,
				$name = WordMother::random(),
				$surname = WordMother::random(),
				$email = WordMother::random(),
				$password = WordMother::random(),
				$role = (new UserMother())->createRandomRole(),
				$isActive = IntegerMother::between(0, 1),
				$trafficPoliceBooth = TrafficPoliceBoothMother::random(),
				true,
				true);
		}
		
		public static function randomWithEmail($email): User
		{
			return self::create(
				$id = Uuid::random(),
				$username = WordMother::random(),
				$name = WordMother::random(),
				$surname = WordMother::random(),
				$email ,
				$password = WordMother::random(),
				$role = (new UserMother())->createRandomRole(),
				$isActive = IntegerMother::between(0, 1),
				$trafficPoliceBooth = TrafficPoliceBoothMother::random(),
				true, true);
		}
		
		public static function randomWithARole( Role $role ): User
		{
			return self::create(
				$id = Uuid::random(),
				$username = WordMother::random(),
				$name = WordMother::random(),
				$surname = WordMother::random(),
				$email = EmailMother::random(),
				$password = PasswordMother::random(),
				$role ,
				$isActive = IntegerMother::between(0, 1),
				$trafficPoliceBooth = TrafficPoliceBoothMother::random(),
				true,
				true);
		}
		
		public static function randomWithARoleAndTrafficPoliceBooth( Role $role, TrafficPoliceBooth $trafficPoliceBooth  ): User
		{
			return self::create(
				$id = Uuid::random(),
				$username = WordMother::random() . IntegerMother::random(),
				$name = WordMother::random() . IntegerMother::random(),
				$surname = WordMother::random() . IntegerMother::random(),
				$email = EmailMother::random(),
				$password = PasswordMother::random(),
				$role ,
				$isActive = IntegerMother::between(0, 1),
				$trafficPoliceBooth,
				true,
				true);
		}
		
		
		
		public static function randomWithRoleWithTrafficPoliceBoothAndUsername( Role $role, TrafficPoliceBooth $trafficPoliceBooth, $username): User
		{
			return self::create(
				$id = Uuid::random(),
				$username,
				$name = WordMother::random(),
				$surname = WordMother::random(),
				$email = EmailMother::random(),
				$password = PasswordMother::random(),
				$role ,
				$isActive = IntegerMother::between(0, 1),
				$trafficPoliceBooth,
				true,
				true);
		}
		
		
		public function uniqueUserNameSpecificationStub()
		{
			return $this->createMock(UniqueUserNameSpecification::class);
			
		}
		
		public function uniqueUserEmailSpecificationStub()
		{
			return $this->createMock(UniqueUserEmailSpecification::class);
		}
		
		
		public static function createRandomRole(): Role
		{
			$roles = array("ROLE_USER", "ROLE_ADMIN");
			
			$role_id = $roles[array_rand($roles, 1)];
			
			return Role::create(
				$role_id,
				WordMother::random()
			);
		}
		
	}
