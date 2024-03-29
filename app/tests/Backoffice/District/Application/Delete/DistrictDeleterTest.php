<?php
	
	declare(strict_types=1);
	
	namespace App\Tests\Backoffice\District\Application\Delete;
	
	use App\Backoffice\District\Application\Delete\DistrictDeleter;
	use App\Backoffice\District\Domain\Exception\DistrictNotExist;
	use App\Backoffice\District\Domain\District;
	use App\Tests\Backoffice\District\Domain\DistrictMother;
	use App\Tests\Backoffice\District\DistrictModuleUnitTestCase;
	use App\Tests\Shared\Domain\UuidMother;
	
	final class DistrictDeleterTest extends DistrictModuleUnitTestCase
	{
		private DistrictDeleter $deleter;
		private District $District;
		
		protected function setUp(): void
		{
			parent::setUp(); // TODO: Change the autogenerated stub
			
			$this->deleter = new DistrictDeleter($this->repository());
			
			$this->District = DistrictMother::random();
		}
		
		/** @test */
		public function it_should_delete_an_existing_traffic_police_booth(): void
		{
			$this->shouldFind($this->District->getId(), $this->District);
			
			$this->repository()
				->shouldReceive('delete')
				->once()
				->with($this->similarTo($this->District));
			
			$this->deleter->__invoke($this->District->getId());
		}
		
		/** @test */
		public function it_should_throw_an_exception_when_the_traffic_police_booth_does_not_exit(): void
		{
			$this->expectException(DistrictNotExist::class);
			
			$this->shouldNotFind($this->District->getId());
			
			$this->repository()
				->shouldReceive('delete')
				->never();
			
			$this->deleter->__invoke($this->District->getId());
		}
	}