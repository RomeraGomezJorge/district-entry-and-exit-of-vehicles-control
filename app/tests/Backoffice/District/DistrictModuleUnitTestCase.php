<?php
	
	declare(strict_types=1);
	
	namespace App\Tests\Backoffice\District;
	
	
	use App\Backoffice\District\Domain\District;
	use App\Backoffice\District\Domain\DistrictRepository;
	use App\Backoffice\District\Domain\UniqueDistrictDescriptionSpecification;
	use App\Shared\Domain\Bus\Event\EventBus;
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
	
	
	abstract class DistrictModuleUnitTestCase extends UnitTestCase
	{
		protected $repository;
		protected $uniqueDistrictDescriptionSpecification;
		protected $bus;
		
		protected function repository(): DistrictRepository
		{
			return $this->repository = $this->repository ?: $this->mock(DistrictRepository::class);
		}
		
		protected function uniqueDistrictDescriptionSpecification(): UniqueDistrictDescriptionSpecification
		{
			return $this->uniqueDistrictDescriptionSpecification = $this->uniqueDistrictDescriptionSpecification ?: $this->mock(UniqueDistrictDescriptionSpecification::class);
		}
		
		protected function bus(): EventBus
		{
			return $this->bus = $this->bus ?: $this->mock(EventBus::class);
		}
		
		public function shouldBeAnUniqueDistrictDescription(string $DistrictDescription): void
		{
			$this->uniqueDistrictDescriptionSpecification()
				->shouldReceive('isSatisfiedBy')
				->once()
				->with($DistrictDescription)
				->andReturn(true);
		}
		
		public function shouldBeNonUniqueDistrictDescription(string $description): void
		{
			$this->uniqueDistrictDescriptionSpecification()
				->shouldReceive('isSatisfiedBy')
				->once()
				->with($description)
				->andReturn(false);
		}
		
		protected function shouldFind(string $id, District $District): void
		{
			$id = new Uuid($id);
			$this->repository()
				->shouldReceive('search')
				->once()
				->with($this->similarTo($id))
				->andReturn($District);
		}
		
		protected function shouldNotFind($id): void
		{
			$id = new Uuid($id);
			
			$this->repository()
				->shouldReceive('search')
				->once()
				->with($this->similarTo($id))
				->andReturn(null);
		}
		
		protected function shouldSave(District $District): void
		{
			$this->repository()
				->shouldReceive('save')
				->once()
				->with($this->similarTo($District))
				->andReturnNull();
		}
		
		
		protected function shouldNotSave()
		{
			$this->repository()
				->shouldReceive('save')
				->never();
		}
		
		protected function shouldNotPublish()
		{
			$this->bus()
				->shouldReceive('publish')
				->never();
		}
	}
