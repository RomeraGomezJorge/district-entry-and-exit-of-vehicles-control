<?php
	
	namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Create;
	
	use App\Backoffice\District\Application\Find\DistrictFinder;
	use App\Backoffice\District\Domain\DistrictRepository;
	use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControl;
	use App\Backoffice\ModelOfVehicle\Application\Find\ModelOfVehicleFinder;
	use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicleRepository;
	use App\Backoffice\ReasonForTrip\Application\Find\ReasonForTripFinder;
	use App\Backoffice\ReasonForTrip\Domain\ReasonForTripRepository;
	use App\Backoffice\TrafficPoliceBooth\Application\Find\TrafficPoliceBoothFinder;
	use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBoothRepository;
	use App\Backoffice\VehicleBodyType\Application\Find\VehicleBodyTypeFinder;
	use App\Backoffice\VehicleBodyType\Domain\VehicleBodyTypeRepository;
	use App\Backoffice\VehicleMakerName\Application\Find\VehicleMakerNameFinder;
	use App\Backoffice\VehicleMakerName\Domain\VehicleMakerNameRepository;
	use App\Shared\Domain\Bus\Event\EventBus;
	use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControlRepository;
	use App\Shared\Domain\ValueObject\Uuid;
	
	final class DistrictEntryAndExitOfVehiclesControlCreator
	{
		private DistrictEntryAndExitOfVehiclesControlRepository $repository;
		private EventBus                                        $bus;
		private VehicleBodyTypeFinder                           $finderVehicleBodyType;
		private ModelOfVehicleFinder                            $finderModelOfVehicle;
		private DistrictFinder                                  $finderDistrict;
		private ReasonForTripFinder                             $finderReasonForTrip;
		private TrafficPoliceBoothFinder                        $finderTrafficPoliceBooth;
		
		public function __construct(
			DistrictEntryAndExitOfVehiclesControlRepository $repository,
			VehicleBodyTypeRepository $vehicleBodyTypeRepository,
			ModelOfVehicleRepository $modelOfVehicleRepository,
			DistrictRepository $districtRepository,
			ReasonForTripRepository $reasonForTripRepository,
			TrafficPoliceBoothRepository $trafficPoliceBoothRepository,
			EventBus $bus
		) {
			$this->repository = $repository;
			$this->finderModelOfVehicle = new ModelOfVehicleFinder($modelOfVehicleRepository);
			$this->finderDistrict = new DistrictFinder($districtRepository);
			$this->finderReasonForTrip = new ReasonForTripFinder($reasonForTripRepository);
			$this->finderTrafficPoliceBooth = new TrafficPoliceBoothFinder($trafficPoliceBoothRepository);
			$this->bus = $bus;
		}
		
		public function __invoke(
			string $id,
			string $licensePlate,
			string $modelOfVehicleId,
			string $tripOriginId,
			string $tripDestinationId,
			string $reasonForTripId,
			string $trafficPoliceBoothId,
			array $vehiclePassenger
		) {
			$id = new Uuid($id);
			
			/* Comprueba la existencia del modelOfVehicle con el id antes de crear
			 un $districtEntryAndExitOfVehiclesControl con ese modelOfVehicle,  evitando
			 inconsistencias en la base de datos, por ej: en caso que este se haya
			eliminado y se guarde el id del modelOfVehicle eliminado */
			$modelOfVehicle = $this->finderModelOfVehicle->__invoke($modelOfVehicleId);
			
			$tripOrigin = $this->finderDistrict->__invoke($tripOriginId);
			
			$tripDestination = $this->finderDistrict->__invoke($tripDestinationId);
			
			$reasonForTrip = $this->finderReasonForTrip->__invoke($reasonForTripId);
			
			$trafficPoliceBooth = $this->finderTrafficPoliceBooth->__invoke($trafficPoliceBoothId);
			
			$createAt = new \DateTime();
			
			$districtEntryAndExitOfVehiclesControl = DistrictEntryAndExitOfVehiclesControl::create($id,
				trim($licensePlate),
				$modelOfVehicle,
				$tripOrigin,
				$tripDestination,
				$reasonForTrip,
				$trafficPoliceBooth,
				$vehiclePassenger,
				$createAt);
			
			$this->repository->save($districtEntryAndExitOfVehiclesControl);
			
			/* Publica el evento de que un $districtEntryAndExitOfVehiclesControl se ha creado y dentro de este evento
			la informacion que este contenia cuando se creo*/
			$this->bus->publish(...$districtEntryAndExitOfVehiclesControl->pullDomainEvents());
		}
	}