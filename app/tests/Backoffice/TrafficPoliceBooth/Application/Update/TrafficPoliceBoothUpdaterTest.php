<?php
	
	declare(strict_types=1);
	
	namespace App\Tests\Backoffice\TrafficPoliceBooth\Application\Update;
	
	use App\Backoffice\TrafficPoliceBooth\Application\Update\TrafficPoliceBoothUpdater;
	use App\Backoffice\TrafficPoliceBooth\Domain\Exception\NonUniqueTrafficPoliceBoothDescription;
	use App\Backoffice\TrafficPoliceBooth\Domain\Exception\TrafficPoliceBoothNotExist;
	use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBooth;
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Tests\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBoothMother;
	use App\Tests\Backoffice\TrafficPoliceBooth\TrafficPoliceBoothModuleUnitTestCase;
	use App\Tests\Shared\Domain\UuidMother;
	use App\Tests\Shared\Domain\WordMother;
	use InvalidArgumentException;
	
	final class TrafficPoliceBoothUpdaterTest extends TrafficPoliceBoothModuleUnitTestCase
	{
		private TrafficPoliceBoothUpdater $updater;
		private TrafficPoliceBooth $trafficPoliceBooth;
		
		protected function setUp(): void
		{
			parent::setUp(); // TODO: Change the autogenerated stub
			
			$this->updater = new TrafficPoliceBoothUpdater($this->repository(),
				$this->uniqueTrafficPoliceBoothDescriptionSpecification());
			
			$this->trafficPoliceBooth = TrafficPoliceBoothMother::random();
		}
		
		/** @test */
		public function it_should_update_an_existing_when_description_is_change(): void
		{
			$newDescription = WordMother::random();
			
			$this->shouldBeAnUniqueTrafficPoliceBoothDescription($newDescription);
			
			$this->shouldFind($this->trafficPoliceBooth->getId(), $this->trafficPoliceBooth);
			
			$this->shouldSave($this->trafficPoliceBooth);
			
			$this->updater->__invoke($this->trafficPoliceBooth->getId(), $newDescription);
		}
		
		/** @test */
		
		public function it_should_not_update_an_existing_description_if_it_does_not_change(): void
		{
			$this->uniqueTrafficPoliceBoothDescriptionSpecification()
				->shouldReceive('isSatisfiedBy')
				->never();
			
			$this->shouldFind($this->trafficPoliceBooth->getId(), $this->trafficPoliceBooth);
			
			$this->shouldSave($this->trafficPoliceBooth);
			
			$this->updater->__invoke($this->trafficPoliceBooth->getId(), $this->trafficPoliceBooth->getDescription());
		}
		
		/** @test */
		public function it_should_throw_an_exception_when_the_traffic_police_booth_does_not_exit(): void
		{
			$this->expectException(TrafficPoliceBoothNotExist::class);
			
			$this->shouldNotFind($this->trafficPoliceBooth->getId());
			
			$this->shouldNotSave();
			
			$this->updater->__invoke($this->trafficPoliceBooth->getId(), $this->trafficPoliceBooth->getDescription());
		}
		
		/** @test */
		public function it_should_throw_an_exception_when_the_description_is_in_use(): void
		{
			$descriptionInUse = WordMother::random();
			
			$this->expectException(NonUniqueTrafficPoliceBoothDescription::class);
			
			$this->shouldBeNonUniqueTrafficPoliceBoothDescription($descriptionInUse);
			
			$this->shouldFind($this->trafficPoliceBooth->getId(), $this->trafficPoliceBooth);
			
			$this->shouldNotSave();
			
			$this->updater->__invoke($this->trafficPoliceBooth->getId(), $descriptionInUse);
		}
		
		/** @test */
		public function it_should_throw_an_exception_when_the_id_is_not_valid(): void
		{
			$this->expectException(InvalidArgumentException::class);
			
			$this->shouldNotSave();
			
			$this->updater->__invoke(UuidMother::invalid(), $this->trafficPoliceBooth->getDescription());
		}
	}

