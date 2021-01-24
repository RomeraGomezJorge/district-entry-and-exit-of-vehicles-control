<?php
	
	declare(strict_types=1);
	
	namespace App\Tests\Backoffice\TrafficPoliceBooth;
	
	
	use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBooth;
	use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBoothRepository;
	use App\Backoffice\TrafficPoliceBooth\Domain\UniqueTrafficPoliceBoothDescriptionSpecification;
	use App\Shared\Domain\Bus\Event\EventBus;
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
	
	
	abstract class TrafficPoliceBoothModuleUnitTestCase extends UnitTestCase
	{
		protected $repository;
		protected $uniqueTrafficPoliceBoothDescriptionSpecification;
		protected $bus;
		
		protected function repository(): TrafficPoliceBoothRepository
		{
			return $this->repository = $this->repository ?: $this->mock(TrafficPoliceBoothRepository::class);
		}
		
		protected function uniqueTrafficPoliceBoothDescriptionSpecification(): UniqueTrafficPoliceBoothDescriptionSpecification
		{
			return $this->uniqueTrafficPoliceBoothDescriptionSpecification = $this->uniqueTrafficPoliceBoothDescriptionSpecification ?: $this->mock(UniqueTrafficPoliceBoothDescriptionSpecification::class);
		}
		
		protected function bus(): EventBus
		{
			return $this->bus = $this->bus ?: $this->mock(EventBus::class);
		}
		
		public function shouldBeAnUniqueTrafficPoliceBoothDescription(string $trafficPoliceBoothDescription): void
		{
			$this->uniqueTrafficPoliceBoothDescriptionSpecification()
				->shouldReceive('isSatisfiedBy')
				->once()
				->with($trafficPoliceBoothDescription)
				->andReturn(true);
		}
		
		public function shouldBeNonUniqueTrafficPoliceBoothDescription(string $description): void
		{
			$this->uniqueTrafficPoliceBoothDescriptionSpecification()
				->shouldReceive('isSatisfiedBy')
				->once()
				->with($description)
				->andReturn(false);
		}
		
		protected function shouldFind(string $id, TrafficPoliceBooth $trafficPoliceBooth): void
		{
			$id = new Uuid($id);
			$this->repository()
				->shouldReceive('search')
				->once()
				->with($this->similarTo($id))
				->andReturn($trafficPoliceBooth);
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
		
		protected function shouldSave(TrafficPoliceBooth $trafficPoliceBooth): void
		{
			$this->repository()
				->shouldReceive('save')
				->once()
				->with($this->similarTo($trafficPoliceBooth))
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
