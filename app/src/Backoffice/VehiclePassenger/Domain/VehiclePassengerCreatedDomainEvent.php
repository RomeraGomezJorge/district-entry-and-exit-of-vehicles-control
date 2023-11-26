<?php

declare(strict_types=1);

namespace App\Backoffice\VehiclePassenger\Domain;

use App\Shared\Domain\Bus\Event\DomainEvent;

final class VehiclePassengerCreatedDomainEvent extends DomainEvent
{
    private string $id;
    private string $name;
    private string $surname;
    private string $identityCard;
    private string $phone;
    private string $address;
    private string $districtEntryAndExitOfVehiclesControl;
    private string $temperatureControl;

    public function __construct(
        string $id,
        string $name,
        string $surname,
        string $identityCard,
        string $phone,
        string $address,
        string $districtEntryAndExitOfVehiclesControl,
        string $temperatureControl,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);
        $this->id                                    = $id;
        $this->name                                  = $name;
        $this->surname                               = $surname;
        $this->identityCard                          = $identityCard;
        $this->phone                                 = $phone;
        $this->address                               = $address;
        $this->districtEntryAndExitOfVehiclesControl = $districtEntryAndExitOfVehiclesControl;
        $this->temperatureControl                    = $temperatureControl;
    }

    public static function eventName(): string
    {
        return 'vehicle_passenger.created';
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function surname(): string
    {
        return $this->surname;
    }

    public function identityCard(): string
    {
        return $this->identityCard;
    }

    public function phone(): string
    {
        return $this->phone;
    }

    public function address(): string
    {
        return $this->address;
    }

    public function districtEntryAndExitOfVehiclesControl(): string
    {
        return $this->districtEntryAndExitOfVehiclesControl;
    }

    public function temperatureControl(): string
    {
        return $this->temperatureControl;
    }
}
