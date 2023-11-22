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
    const PASSENGER_PREFIX_TO_SESSION_VALUES = 'inputs.vehiclePassenger.0.';
    private FlashSession $flashSession;

    public function __construct(FlashSession $flashSession)
    {
        $this->flashSession = $flashSession;
    }

    public function __invoke()
    {
        $passengerInFlashSession = array();

        for ($passengerCounter = 0; $passengerCounter < 20; $passengerCounter++) {
            /* en caso de no existir confirma que no hay mas pasajeros en la flash session*/
            if (!$this->isThereAnotherPassengerStoredInSession($passengerCounter)) {
                break;
            }

            $passengerInFlashSession[$passengerCounter]['surname'] = $this->getPassengerFieldFromFlashSession(
                $passengerCounter,
                'surname'
            );

            $passengerInFlashSession[$passengerCounter]['name'] = $this->getPassengerFieldFromFlashSession(
                $passengerCounter,
                'name'
            );

            $passengerInFlashSession[$passengerCounter]['identityCardType']['id'] = $this->getPassengerFieldFromFlashSession(
                $passengerCounter,
                'identityCardTypeId'
            );

            $passengerInFlashSession[$passengerCounter]['identityCard'] = $this->getPassengerFieldFromFlashSession(
                $passengerCounter,
                'identityCard'
            );

            $passengerInFlashSession[$passengerCounter]['phone'] = $this->getPassengerFieldFromFlashSession(
                $passengerCounter,
                'phone'
            );

            $passengerInFlashSession[$passengerCounter]['address'] = $this->getPassengerFieldFromFlashSession(
                $passengerCounter,
                'address'
            );

            $passengerInFlashSession[$passengerCounter]['temperatureControl'] = $this->getPassengerFieldFromFlashSession(
                $passengerCounter,
                'temperatureControl'
            );
        }

        return (empty($passengerInFlashSession)) ? array(self::EMPTY_VEHICLE_PASSENGER) : $passengerInFlashSession;
    }

    private function isThereAnotherPassengerStoredInSession($passengerCounter): bool
    {
        return !empty($this->flashSession->get(self::PASSENGER_PREFIX_TO_SESSION_VALUES . $passengerCounter . '.name'))
            ? true
            : false;
    }

    private function getPassengerFieldFromFlashSession(int $passengerNumber, string $fieldName)
    {
        $passengerFieldFromFlashSession = $this->flashSession->get(self::PASSENGER_PREFIX_TO_SESSION_VALUES . $passengerNumber . '.' . $fieldName);

        if (empty($passengerFieldFromFlashSession)) {
            $newPassenger[$passengerNumber][$fieldName] = '';
        }

        return $newPassenger[$passengerNumber][$fieldName] = $passengerFieldFromFlashSession;
    }
}
