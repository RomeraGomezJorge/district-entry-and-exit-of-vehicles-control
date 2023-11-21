<?php

declare(strict_types=1);

namespace App\Tests\Backoffice\District\Application\Create;

use App\Backoffice\District\Domain\Exception\NonUniqueTagDescription;
use App\Backoffice\District\Domain\District;
use App\Backoffice\District\Application\Create\DistrictCreator;
use App\Backoffice\District\Domain\Exception\NonUniqueDistrictDescription;
use App\Tests\Backoffice\District\Domain\DistrictMother;
use App\Tests\Backoffice\District\DistrictModuleUnitTestCase;
use App\Tests\Shared\Domain\UuidMother;
use App\Tests\Shared\Domain\WordMother;
use InvalidArgumentException;



final class DistrictCreatorTest extends DistrictModuleUnitTestCase
{
	private DistrictCreator $creator;
	private District $District;
	
	protected function setUp(): void
	{
		parent::setUp(); // TODO: Change the autogenerated stub
		
		$this->creator = new DistrictCreator($this->repository(),$this->uniqueDistrictDescriptionSpecification(),$this->bus());
		
		$this->District = DistrictMother::random();
	}
	
	/** @test */
    public function it_should_create_a_valid_traffic_police_booth(): void
    {
	    $this->shouldBeAnUniqueDistrictDescription($this->District->getDescription());
	
	    $this->shouldSave($this->District);
	
	    $this->bus();
	    
	    $this->bus->shouldReceive('publish')->once()->andReturnNull();		    ;
	    
	    $this->creator->__invoke($this->District->getId(),$this->District->getDescription());
    }
    
    /** @test */
    public function it_should_throw_an_exception_when_the_description_is_in_use(): void
    {
	    $this->expectException(NonUniqueDistrictDescription::class);
	    
	    $this->shouldBeNonUniqueDistrictDescription($this->District->getDescription());
	    
	    $this->shouldNotSave();
	
	    $this->shouldNotPublish();
	
	    $this->creator->__invoke($this->District->getId(),$this->District->getDescription());
    }
    
    /** @test */
    public function it_should_throw_an_exception_when_the_id_is_not_valid(): void
    {
	    $this->expectException(InvalidArgumentException::class);
	
	    $this->shouldNotSave();
	    
	    $this->shouldNotPublish();
	
	    $this->creator->__invoke(UuidMother::invalid(),WordMother::random());
    }
}
