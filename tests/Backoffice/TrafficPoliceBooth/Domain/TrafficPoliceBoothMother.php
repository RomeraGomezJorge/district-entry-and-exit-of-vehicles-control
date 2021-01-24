<?php

declare(strict_types=1);

namespace App\Tests\Backoffice\TrafficPoliceBooth\Domain;

use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBooth;
use App\Backoffice\TrafficPoliceBooth\Domain\UniqueTrafficPoliceBoothDescriptionSpecification;
use App\Shared\Domain\ValueObject\Uuid;
use App\Tests\Shared\Domain\WordMother;
use PHPUnit\Framework\TestCase;


final class TrafficPoliceBoothMother extends testCase
{
    public static function create(Uuid $id, string $description, bool $isDescriptionInUse ): TrafficPoliceBooth
    {
	    $uniqueTrafficPoliceBoothDescriptionSpecificationStub  = (new TrafficPoliceBoothMother)->uniqueTagDescriptionSpecificationStub();
	    
	    $uniqueTrafficPoliceBoothDescriptionSpecificationStub->method('isSatisfiedBy')->willReturn($isDescriptionInUse);
	    
        return  TrafficPoliceBooth::create(
        	$id,
	        $description,
	        new \DateTime(),
	        $uniqueTrafficPoliceBoothDescriptionSpecificationStub
        );
    }

    public static function random(): TrafficPoliceBooth
    {
        return self::create(Uuid::random(), WordMother::random(),true);
    }
    
    public static function randomWithDescription( $description ): TrafficPoliceBooth
    {
        return self::create(Uuid::random(),$description,true);
    }
    
    public function uniqueTagDescriptionSpecificationStub()
    {
	    return $this->createMock(UniqueTrafficPoliceBoothDescriptionSpecification::class);

    }
}
