<?php

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Infrastructure\UserInterface\Web;

use App\Backoffice\District\Application\FindByCriteriaSearcher\DistrictsByCriteriaSearcher;
use App\Backoffice\ModelOfVehicle\Application\FindByCriteriaSearcher\ModelsOfVehicleByCriteriaSearcher;
use App\Backoffice\ReasonForTrip\Application\FindByCriteriaSearcher\ReasonsForTripByCriteriaSearcher;
use App\Backoffice\TrafficPoliceBooth\Application\FindByCriteriaSearcher\TrafficPoliceBoothsByCriteriaSearcher;
use App\Backoffice\VehicleBodyType\Application\FindByCriteriaSearcher\VehicleBodyTypesByCriteriaSearcher;
use App\Backoffice\VehicleMakerName\Application\FindByCriteriaSearcher\VehicleMakersNameByCriteriaSearcher;

final class RelatedEntities
{
    
    const DISPLAY_ALL_VEHICLE_MAKER_NAME = [];
    
    const SORT_A_LIST_BY_DESCRIPTION     = 'description';
    
    const SORT_A_LIST_ALPHABETICALLY     = 'asc';
    
    const LIST_BEGIN_ON_0                = 0;
    
    const LIST_END_ON_1000               = 1000;
    
    private VehicleBodyTypesByCriteriaSearcher    $bodyTypesByCriteriaSearcher;
    
    private VehicleMakersNameByCriteriaSearcher   $vehicleMakersNameByCriteriaSearcher;
    
    private ModelsOfVehicleByCriteriaSearcher     $modelsOfVehicleByCriteriaSearcher;
    
    private DistrictsByCriteriaSearcher           $districtsByCriteriaSearcher;
    
    private ReasonsForTripByCriteriaSearcher      $reasonsForTripByCriteriaSearcher;
    
    private TrafficPoliceBoothsByCriteriaSearcher $trafficPoliceBoothsByCriteriaSearcher;
    
    public function __construct(
        VehicleBodyTypesByCriteriaSearcher $bodyTypesByCriteriaSearcher,
        VehicleMakersNameByCriteriaSearcher $vehicleMakersNameByCriteriaSearcher,
        ModelsOfVehicleByCriteriaSearcher $modelsOfVehicleByCriteriaSearcher,
        DistrictsByCriteriaSearcher $districtsByCriteriaSearcher,
        ReasonsForTripByCriteriaSearcher $reasonsForTripByCriteriaSearcher,
        TrafficPoliceBoothsByCriteriaSearcher $trafficPoliceBoothsByCriteriaSearcher
    )
    {
        $this->bodyTypesByCriteriaSearcher = $bodyTypesByCriteriaSearcher;
        $this->vehicleMakersNameByCriteriaSearcher = $vehicleMakersNameByCriteriaSearcher;
        $this->modelsOfVehicleByCriteriaSearcher = $modelsOfVehicleByCriteriaSearcher;
        $this->districtsByCriteriaSearcher = $districtsByCriteriaSearcher;
        $this->reasonsForTripByCriteriaSearcher = $reasonsForTripByCriteriaSearcher;
        $this->trafficPoliceBoothsByCriteriaSearcher = $trafficPoliceBoothsByCriteriaSearcher;
    }
    
    public function getAllVehicleBodyTypesSortAlphabetically(): array
    {
        return $this->bodyTypesByCriteriaSearcher->__invoke( self::DISPLAY_ALL_VEHICLE_MAKER_NAME,
            self::SORT_A_LIST_BY_DESCRIPTION,
            self::SORT_A_LIST_ALPHABETICALLY,
            self::LIST_END_ON_1000,
            self::LIST_BEGIN_ON_0 );
    }
    
    public function getAllVehicleMarkersNameSortAlphabetically(): array
    {
        return $this->vehicleMakersNameByCriteriaSearcher->__invoke( self::DISPLAY_ALL_VEHICLE_MAKER_NAME,
            self::SORT_A_LIST_BY_DESCRIPTION,
            self::SORT_A_LIST_ALPHABETICALLY,
            self::LIST_END_ON_1000,
            self::LIST_BEGIN_ON_0 );
    }
    
    public function getAllModelsOfVehicleSortAlphabetically(): array
    {
        return $this->modelsOfVehicleByCriteriaSearcher->__invoke( self::DISPLAY_ALL_VEHICLE_MAKER_NAME,
            self::SORT_A_LIST_BY_DESCRIPTION,
            self::SORT_A_LIST_ALPHABETICALLY,
            self::LIST_END_ON_1000,
            self::LIST_BEGIN_ON_0 );
    }
    
    public function getAllDistrictsSortAlphabetically(): array
    {
        return $this->districtsByCriteriaSearcher->__invoke( self::DISPLAY_ALL_VEHICLE_MAKER_NAME,
            self::SORT_A_LIST_BY_DESCRIPTION,
            self::SORT_A_LIST_ALPHABETICALLY,
            self::LIST_END_ON_1000,
            self::LIST_BEGIN_ON_0 );
    }
    
    public function getAllReasonsForTriSortAlphabetically(): array
    {
        return $this->reasonsForTripByCriteriaSearcher->__invoke( self::DISPLAY_ALL_VEHICLE_MAKER_NAME,
            self::SORT_A_LIST_BY_DESCRIPTION,
            self::SORT_A_LIST_ALPHABETICALLY,
            self::LIST_END_ON_1000,
            self::LIST_BEGIN_ON_0 );
    }
    
    public function getAllTrafficPoliceBoothsSortAlphabetically(): array
    {
        return $this->trafficPoliceBoothsByCriteriaSearcher->__invoke( self::DISPLAY_ALL_VEHICLE_MAKER_NAME,
            self::SORT_A_LIST_BY_DESCRIPTION,
            self::SORT_A_LIST_ALPHABETICALLY,
            self::LIST_END_ON_1000,
            self::LIST_BEGIN_ON_0 );
    }
    
}