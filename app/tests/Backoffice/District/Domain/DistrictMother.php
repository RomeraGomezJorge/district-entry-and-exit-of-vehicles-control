<?php

declare(strict_types=1);

namespace App\Tests\Backoffice\District\Domain;

use App\Backoffice\District\Domain\District;
use App\Backoffice\District\Domain\UniqueDistrictDescriptionSpecification;
use App\Shared\Domain\ValueObject\Uuid;
use App\Tests\Shared\Domain\WordMother;
use PHPUnit\Framework\TestCase;


final class DistrictMother extends testCase
{
    public static function create(Uuid $id, string $description, bool $isDescriptionInUse ): District
    {
	    $uniqueDistrictDescriptionSpecificationStub  = (new DistrictMother)->uniqueTagDescriptionSpecificationStub();
	    
	    $uniqueDistrictDescriptionSpecificationStub->method('isSatisfiedBy')->willReturn($isDescriptionInUse);
	    
        return  District::create(
        	$id,
	        $description,
	        new \DateTime(),
	        $uniqueDistrictDescriptionSpecificationStub
        );
    }

    public static function random(): District
    {
        return self::create(Uuid::random(), WordMother::random(),true);
    }
    
    public static function randomWithDescription( $description ): District
    {
        return self::create(Uuid::random(),$description,true);
    }
    
    public function uniqueTagDescriptionSpecificationStub()
    {
	    return $this->createMock(UniqueDistrictDescriptionSpecification::class);

    }
}
