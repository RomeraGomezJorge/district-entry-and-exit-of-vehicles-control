<?php
	
	namespace App\Backoffice\VehiclePassenger\Domain;
	
	
	use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControl;
	use App\Backoffice\IdentityCardType\Domain\IdentityCardType;
	use App\Shared\Domain\Aggregate\AggregateRoot;
	use App\Shared\Domain\ValueObject\Uuid;
	use DateTime;
	
	class VehiclePassenger extends AggregateRoot
	{
		private string $id;
		private string $name;
		private string $surname;
		private string $identityCard;
		private string $phone;
		private string $address;
		private $districtEntryAndExitOfVehiclesControl;
		private IdentityCardType $identityCardType;
		private string $temperatureControl;
		private DateTime $createAt;
		private DateTime $updateAt;
		
		public static function create(
			Uuid $id,
			string $name,
			string $surname,
			string $identityCard,
			string $phone,
			string $address,
			DistrictEntryAndExitOfVehiclesControl $districtEntryAndExitOfVehiclesControl,
			IdentityCardType $identityCardType,
			string $temperatureControl,
			DateTime $createAt
		): self {
			$vehiclePassenger = new self();
			$vehiclePassenger->id = $id->value();
			$vehiclePassenger->name = $name;
			$vehiclePassenger->surname = $surname;
			$vehiclePassenger->identityCard = $identityCard;
			$vehiclePassenger->phone = $phone;
			$vehiclePassenger->address = $address;
			$vehiclePassenger->districtEntryAndExitOfVehiclesControl = $districtEntryAndExitOfVehiclesControl;
			$vehiclePassenger->identityCardType = $identityCardType;
			$vehiclePassenger->temperatureControl = $temperatureControl;
			$vehiclePassenger->createAt = $createAt;
			$vehiclePassenger->updateAt = $createAt;
			
			$vehiclePassenger->record(new VehiclePassengerCreatedDomainEvent(
				$id->value(),
				$name,
				$surname,
				$identityCard,
				$phone,
				$address,
				$districtEntryAndExitOfVehiclesControl->getId(),
				$temperatureControl));
			
			
			return $vehiclePassenger;
		}
		
		public function getId(): string
		{
			return $this->id;
		}
		
		public function setId(string $id): void
		{
			$this->id = $id;
		}
		
		public function getName(): string
		{
			return $this->name;
		}
		
		public function setName(string $name): void
		{
			$this->name = $name;
		}
		
		public function getSurname(): string
		{
			return $this->surname;
		}
		
		public function setSurname(string $surname): void
		{
			$this->surname = $surname;
		}
		
		public function getIdentityCard(): string
		{
			return $this->identityCard;
		}
		
		public function setIdentityCard(string $identityCard): void
		{
			$this->identityCard = $identityCard;
		}
		
		public function getPhone(): string
		{
			return $this->phone;
		}
		
		public function setPhone(string $phone): void
		{
			$this->phone = $phone;
		}
		
		public function getAddress(): string
		{
			return $this->address;
		}
		
		public function setAddress(string $address): void
		{
			$this->address = $address;
		}
		
		public function getDistrictEntryAndExitOfVehiclesControl(): DistrictEntryAndExitOfVehiclesControl
		{
			return $this->districtEntryAndExitOfVehiclesControl;
		}
		
		public function setDistrictEntryAndExitOfVehiclesControl(
			DistrictEntryAndExitOfVehiclesControl $districtEntryAndExitOfVehiclesControl
		): void {
			$this->districtEntryAndExitOfVehiclesControl = $districtEntryAndExitOfVehiclesControl;
		}
		
		public function getTemperatureControl(): string
		{
			return $this->temperatureControl;
		}
		
		public function setTemperatureControl(string $temperatureControl): void
		{
			$this->temperatureControl = $temperatureControl;
		}
		
		public function getCreateAt(): DateTime
		{
			return $this->createAt;
		}
		
		public function setCreateAt(DateTime $createAt): void
		{
			$this->createAt = $createAt;
		}
		
		public function getUpdateAt(): DateTime
		{
			return $this->updateAt;
		}
		
		public function setUpdateAt(DateTime $updateAt): void
		{
			$this->updateAt = $updateAt;
		}
		
		public function getIdentityCardType(): IdentityCardType
		{
			return $this->identityCardType;
		}
		
		public function setIdentityCardType(IdentityCardType $identityCardType): void
		{
			$this->identityCardType = $identityCardType;
		}
		
		
	}
