<?php
	
	
	namespace App\Backoffice\VehiclePassenger\Application\FindByDistrictEntryAndExitOfVehiclesControl;
	
	
	use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Find\DistrictEntryAndExitOfVehiclesControlFinder;
	use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControlRepository;
	use App\Backoffice\VehiclePassenger\Domain\Exception\VehiclePassengerNotFound;
	use App\Backoffice\VehiclePassenger\Domain\VehiclePassengerRepository;
	
	
	final class FindVehiclePassengersByDistrictEntryAndExitOfVehiclesControl
	{
		private VehiclePassengerRepository $repository;
		private DistrictEntryAndExitOfVehiclesControlFinder $finderDistrictEntryAndExitOfVehiclesControl;
		
		public function __construct(
			VehiclePassengerRepository $vehiclePassengerRepository,
			DistrictEntryAndExitOfVehiclesControlRepository $DistrictEntryAndExitOfVehiclesControlRepository
		) {
			$this->repository = $vehiclePassengerRepository;
			$this->finderDistrictEntryAndExitOfVehiclesControl = new DistrictEntryAndExitOfVehiclesControlFinder($DistrictEntryAndExitOfVehiclesControlRepository);
		}
		
		public function __invoke(string $districtEntryAndExitOfVehiclesControlId)
		{
			$districtEntryAndExitOfVehiclesControl = $this->finderDistrictEntryAndExitOfVehiclesControl->__invoke($districtEntryAndExitOfVehiclesControlId);
			
			$vehiclePassenger = $this->repository->findVehiclePassengersIn($districtEntryAndExitOfVehiclesControl->getId());
			
			if (empty($vehiclePassenger)) {
				throw new VehiclePassengerNotFound($districtEntryAndExitOfVehiclesControlId);
			}
			
			return $vehiclePassenger;
		}
	}