<?php
	
	
	namespace App\Tests\Backoffice\User\Infrastructure\Specification;
	
	use App\Backoffice\User\Domain\UniqueUserEmailSpecification;
	use App\Tests\Backoffice\User\UserInfrastructureTestCase;
	use App\Tests\Shared\Domain\WordMother;
	
	
	final class UniqueUserEmailSpecificationTest extends UserInfrastructureTestCase
	{
		
		private $user;
		
		protected function setUp(): void
		{
			parent::setUp(); // TODO: Change the autogenerated stub
			
			$this->user = $this->getUserCreatedForTest();
			
			$this->repository()->save($this->user);;
		}
		
		/** @test */
		public function it_should_return_false_if_email_is_in_use(): void
		{
			
			$isInUse = $this->uniqueUserEmailSpecification()->isSatisfiedBy($this->user->getEmail());
			
			$this->assertEquals($isInUse, false);
		}
		
		/** @test */
		public function it_should_return_true_if_email_is_not_in_use(): void
		{
			$newEmail = WordMother::random();
			
			$isInUse = $this->uniqueUserEmailSpecification()->isSatisfiedBy($newEmail);
			
			$this->assertEquals($isInUse, true);
		}
		
		protected function uniqueUserEmailSpecification(): UniqueUserEmailSpecification
		{
			return $this->service(UniqueUserEmailSpecification::class);
		}
		
		
	}