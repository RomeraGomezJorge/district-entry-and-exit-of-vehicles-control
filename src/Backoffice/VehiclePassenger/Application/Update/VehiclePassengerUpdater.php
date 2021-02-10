<?php namespace App\Backoffice\VehiclePassenger\Application\Update;

use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Find\DistrictEntryAndExitOfVehiclesControlFinder;
use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControl;
use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControlRepository;
use App\Backoffice\VehiclePassenger\Application\Find\VehiclePassengerFinder;
use App\Backoffice\VehiclePassenger\Domain\VehiclePassenger;
use App\Backoffice\VehiclePassenger\Domain\VehiclePassengerRepository;
use App\Shared\Infrastructure\Utils\StringUtils;

final class VehiclePassengerUpdater
{
	private VehiclePassengerRepository $repository;
	private VehiclePassengerFinder  $finder;
	private DistrictEntryAndExitOfVehiclesControlFinder $finderDistrictEntryAndExitOfVehiclesControl;
	
	
	public function __construct(
		VehiclePassengerRepository $repository,
		DistrictEntryAndExitOfVehiclesControlRepository $districtEntryAndExitOfVehiclesControlRepository
		
	) {
		$this->repository = $repository;
		$this->finder = new VehiclePassengerFinder($repository);
		$this->finderDistrictEntryAndExitOfVehiclesControl = new DistrictEntryAndExitOfVehiclesControlFinder(
			$districtEntryAndExitOfVehiclesControlRepository);
	}
	
	public function __invoke(
		string $id,
		string $newName,
		string $newSurname,
		string $newIdentityCard,
		string $newPhone,
		string $newAddress,
		string $districtEntryAndExitOfVehiclesControlId,
		string $neTemperatureControl
	): void {
		$vehiclePassenger = $this->finder->__invoke($id);
		
		$districtEntryAndExitOfVehiclesControl = $this->finderDistrictEntryAndExitOfVehiclesControl->__invoke($districtEntryAndExitOfVehiclesControlId);
		
		if ($this->hasNameChanged($newName, $vehiclePassenger)) {
			$vehiclePassenger->setName(trim($newName));
		}
		
		if ($this->hasSurnameChanged($newSurname, $vehiclePassenger)) {
			$vehiclePassenger->setSurname(trim($newSurname));
		}
		if ($this->hasIdentityCardChanged($newIdentityCard, $vehiclePassenger)) {
			$vehiclePassenger->setIdentityCard(trim($newIdentityCard));
		}
		
		if ($this->hasPhoneChanged($newPhone, $vehiclePassenger)) {
			$vehiclePassenger->setPhone(trim($newPhone));
		}
		
		if ($this->hasAddressChanged($newAddress, $vehiclePassenger)) {
			$vehiclePassenger->setAddress(trim($newAddress));
		}
		
		if ($this->hasDistrictEntryAndExitOfVehiclesControlChanged(
			$districtEntryAndExitOfVehiclesControl,
			$vehiclePassenger)
		) {
			$vehiclePassenger->setDistrictEntryAndExitOfVehiclesControl($districtEntryAndExitOfVehiclesControl);
		}
		
		if ($this->hasTemperatureControlChanged($neTemperatureControl, $vehiclePassenger)) {
			$vehiclePassenger->setTemperatureControl(trim($neTemperatureControl));
		}
		
		$vehiclePassenger->setUpdateAt(new \DateTime());
		
		$this->repository->save($vehiclePassenger);
	}
	
	private function hasNameChanged(string $newName, VehiclePassenger $vehiclePassenger): bool
	{
		return !StringUtils::equals($newName, $vehiclePassenger->getName());
	}
	
	private function hasSurnameChanged(string $newSurname, VehiclePassenger $vehiclePassenger): bool
	{
		return !StringUtils::equals($newSurname, $vehiclePassenger->getSurname());
	}
	
	private function hasIdentityCardChanged(string $newIdentityCard, VehiclePassenger $vehiclePassenger): bool
	{
		return !StringUtils::equals($newIdentityCard, $vehiclePassenger->getName());
	}
	
	private function hasPhoneChanged(string $phone, VehiclePassenger $vehiclePassenger): bool
	{
		return !StringUtils::equals($phone, $vehiclePassenger->getPhone());
	}
	
	private function hasAddressChanged(string $newAddress, VehiclePassenger $vehiclePassenger): bool
	{
		return !StringUtils::equals($newAddress, $vehiclePassenger->getAddress());
	}
	
	private function hasDistrictEntryAndExitOfVehiclesControlChanged(
		DistrictEntryAndExitOfVehiclesControl $newDistrictEntryAndExitOfVehiclesControlId,
		VehiclePassenger $vehiclePassenger
	): bool {
		return !StringUtils::equals($newDistrictEntryAndExitOfVehiclesControlId->getId(),
			$vehiclePassenger->getDistrictEntryAndExitOfVehiclesControl()->getId());
	}
	
	private function hasTemperatureControlChanged(
		string $newTemperatureControl,
		VehiclePassenger $vehiclePassenger
	): bool {
		return !StringUtils::equals($newTemperatureControl, $vehiclePassenger->getTemperatureControl());
	}
}