<?php

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Infrastructure\UserInterface\Web;

use App\Shared\Infrastructure\Symfony\FlashSession;

final class PassengersInFlashSession
{

    const EMPTY_VEHICLE_PASSENGER = array(
        'name'               => '',
        'surname'            => '',
        'identityCard'       => '',
        'identityCardType'   => array('id' => ''),
        'phone'              => '',
        'address'            => '',
        'temperatureControl' => ''
    );
    private const MAX_IN_VEHICLE_PASSENGERS = 20;
    const PASSENGER_PREFIX_TO_SESSION_VALUES = 'inputs.vehicle_passenger.0.';
    private FlashSession $flashSession;

    public function __construct(FlashSession $flashSession)
    {
        $this->flashSession = $flashSession;
    }

    public function __invoke()
    {
        $passengerInFlashSession = [];

        for ($passengerCounter = 0; $passengerCounter < self::MAX_IN_VEHICLE_PASSENGERS; $passengerCounter++) {

            if (!$this->isThereAnotherPassengerStoredInSession($passengerCounter)) {
                break;
            }

            $passengerInFlashSession[$passengerCounter] = [
                'name'               => $this->getPassengerFieldFromFlashSession($passengerCounter, 'name'),
                'surname'            => $this->getPassengerFieldFromFlashSession($passengerCounter, 'surname'),
                'identityCardType'   => ['id' => $this->getPassengerFieldFromFlashSession($passengerCounter, 'identityCardTypeId')],
                'identityCard'       => $this->getPassengerFieldFromFlashSession($passengerCounter, 'identityCard'),
                'phone'              => $this->getPassengerFieldFromFlashSession($passengerCounter, 'phone'),
                'address'            => $this->getPassengerFieldFromFlashSession($passengerCounter, 'address'),
                'temperatureControl' => $this->getPassengerFieldFromFlashSession($passengerCounter, 'temperatureControl'),
            ];

        }

        return (empty($passengerInFlashSession))
            ? [self::EMPTY_VEHICLE_PASSENGER]
            : $passengerInFlashSession;
    }

    private function isThereAnotherPassengerStoredInSession($passengerCounter): bool
    {
        return $this->flashSession->has(self::PASSENGER_PREFIX_TO_SESSION_VALUES . $passengerCounter . '.name');
    }

    private function getPassengerFieldFromFlashSession(int $passengerNumber, string $fieldName)
    {
        $valueFromFlashSession = $this->flashSession->get(self::PASSENGER_PREFIX_TO_SESSION_VALUES . $passengerNumber . '.' . $fieldName);

        return $valueFromFlashSession ?? '';
    }
}
