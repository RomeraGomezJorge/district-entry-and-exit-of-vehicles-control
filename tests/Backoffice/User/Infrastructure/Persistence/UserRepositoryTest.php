<?php
	
	declare(strict_types=1);
	
	namespace App\Tests\Backoffice\User\Infrastructure\Persistence;
	
	use App\Tests\Backoffice\User\Domain\UserMother;
	use App\Tests\Backoffice\User\UserInfrastructureTestCase;
	use App\Tests\Shared\Domain\Criteria\CriteriaMother;
	use App\Shared\Domain\ValueObject\Uuid;
	
	
	final class UserRepositoryTest extends UserInfrastructureTestCase
	{

		private Uuid $id;
		const ROLE_HAS_BEEN_NOT_DEFINE_AS_FILTER = null;
		private $user;
		
		protected function setUp(): void
		{
			parent::setUp();
			
			$this->user = $this->getUserCreatedForTest();
			
			$this->id = new Uuid($this->user->getId());
		}
		
		/** @test */
		public function it_should_save_a_user(): void
		{
			$this->repository()->save($this->user);
			
			$this->clearUnitOfWork();
			
			$this->assertNotNull($this->repository()->search($this->id));
		}
		
		/** @test */
		public function it_should_return_an_existing_user(): void
		{
			$this->repository()->save($this->user);
			
			$this->clearUnitOfWork();
			
			$userFound = $this->repository()->search($this->id);
			
			$this->assertEquals($userFound->getName(), $this->user->getName());
			$this->assertEquals($userFound->getEmail(), $this->user->getEmail());
			$this->assertEquals($userFound->getPassword(), $this->user->getPassword());
			$this->assertEquals($userFound->getUsername(), $this->user->getUsername());
			$this->assertEquals($userFound->getRole()->getId(), $this->user->getRole()->getId());
		}
		
		/** @test */
		public function it_should_not_return_a_non_existing_user(): void
		{
			$this->assertNull($this->repository()->search($this->id));
		}
		
		/** @test */
		public function it_should_delete_an_existing_user()
		{
			$this->repository()->save($this->user);
			
			$this->clearUnitOfWork();
			
			$userFound = $this->repository()->search($this->id);
			
			$this->assertNull(
				$this->repository()->delete($userFound)
			);
		}
		
		
		/** @test */
		public function it_should_search_all_existing_user(): void
		{
			$existingUser = UserMother::randomWithARoleAndTrafficPoliceBooth($this->roleFound,$this->trafficPoliceBoothFound);
			$anotherExistingUser = $this->user;
			$existingAuthors = [$existingUser, $anotherExistingUser];
			
			$this->repository()->save($existingUser);
			$this->repository()->save($anotherExistingUser);
			$this->clearUnitOfWork();
			
			$this->assertEquals(
				count($existingAuthors),
				count($this->repository()->searchAll())
			);
		}
		
		/** @test */
		public function it_should_search_all_existing_users_with_an_empty_criteria(): void
		{
			$existingUser = UserMother::randomWithARoleAndTrafficPoliceBooth($this->roleFound, $this->trafficPoliceBoothFound);
			$anotherExistingUser = $this->user;
			$existingUsers = [$existingUser, $anotherExistingUser];
			
			$this->repository()->save($existingUser);
			$this->repository()->save($anotherExistingUser);
			$this->clearUnitOfWork();
			
			$this->assertEquals(
				count($existingUsers),
				count($this->repository()->matching(CriteriaMother::empty(), self::ROLE_HAS_BEEN_NOT_DEFINE_AS_FILTER))
			);
		}
		
		/** @test */
		public function it_should_filter_by_criteria(): void
		{
			$dddInPhpUser = UserMother::randomWithRoleWithTrafficPoliceBoothAndUsername($this->roleFound, $this->trafficPoliceBoothFound, 'DDD en PHP');
			$dddInJavaUser = UserMother::randomWithRoleWithTrafficPoliceBoothAndUsername($this->roleFound, $this->trafficPoliceBoothFound, 'DDD en Java');
			$intellijUser = UserMother::randomWithRoleWithTrafficPoliceBoothAndUsername($this->roleFound, $this->trafficPoliceBoothFound, 'Exprimiendo Intellij');
			$dddUsers = [$dddInPhpUser, $dddInJavaUser];
			
			$usernameContainsDddCriteria = CriteriaMother::Contains('username', 'DDD');
			
			$this->repository()->save($dddInJavaUser);
			$this->repository()->save($dddInPhpUser);
			$this->repository()->save($intellijUser);
			$this->clearUnitOfWork();
			
			$this->assertEquals(
				count($dddUsers),
				count($this->repository()->matching($usernameContainsDddCriteria,
					self::ROLE_HAS_BEEN_NOT_DEFINE_AS_FILTER))
			);
			
		}

	}
