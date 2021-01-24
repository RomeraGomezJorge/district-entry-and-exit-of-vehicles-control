<?php
	
	
	namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Shared;
	
	
	use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControlRepository;
	use App\Backoffice\VehiclePassenger\Application\FindByCriteriaSearcher\VehiclePassengersByCriteriaSearcher;
	use App\Shared\Infrastructure\Utils\FilterUtilsForFieldThatNotBelongToAnEntity;
	
	final class FilterUtilsForDistrictEntryAndExitOfVehiclesControl
	{
		const FIELDS_NAME_THAT_DOES_NOT_BELONG_TO_THE_ENTITY_IN_THE_FILTER_FORM = ['name', 'surname', 'identityCard'];
		const PASSENGER_FILTERS_NOT_FOUND = [];
		const NOT_PASSENGERS_FOUND_AFTER_SEARCH = null;
		
		private DistrictEntryAndExitOfVehiclesControlRepository $repository;
		private VehiclePassengersByCriteriaSearcher $vehiclePassengersByCriteriaSearcher;
		
		public function __construct(
			DistrictEntryAndExitOfVehiclesControlRepository $repository,
			VehiclePassengersByCriteriaSearcher $vehiclePassengersByCriteriaSearcher
		) {
			$this->repository = $repository;
			$this->vehiclePassengersByCriteriaSearcher = $vehiclePassengersByCriteriaSearcher;
		}
		
		/* Remueve de $filtres todos los campos que no le correspondan a la entidad DistrictEntryAndExitOfVehiclesControl */
		public function removeFiltersThatNotBelongToEntityIn($filters): array
		{
			return FilterUtilsForFieldThatNotBelongToAnEntity::removeFilterEqualsTo(
				self::FIELDS_NAME_THAT_DOES_NOT_BELONG_TO_THE_ENTITY_IN_THE_FILTER_FORM,
				$filters);
		}
		
		/* Retorna los pasajeros  que se han encontrado en base a los filtros aplicados*/
		public function findPassengersByFilters($filters, $order, $orderBy, $limit, $offset): ?array
		{
			if (!$this->areTherePassengersFilterIn($filters)) {
				return self::PASSENGER_FILTERS_NOT_FOUND;
			}
			
			$passengersFound = $this->vehiclePassengersByCriteriaSearcher->__invoke($filters, $order, $orderBy, $limit,
				$offset);
			
			if (empty($passengersFound)) {
				return self::NOT_PASSENGERS_FOUND_AFTER_SEARCH;
			}
			
			return $passengersFound;
			
		}
		
		/* Comprueba si dentro de $filters exiten los campos utilzados para fitrar pasajeros  */
		private function areTherePassengersFilterIn($filters)
		{
			$areThereFiltersForPassengers = false;
			
			/* obtiene un array con todos los campos por los que se puede buscar */
			$fieldsFoundInFilters = array_column($filters, 'field');
			
			foreach ($fieldsFoundInFilters as $filterFound) {
				/* comprueba si el campos encontrados  esta dentro de los filtros que se usan para los pasajeros */
				if (in_array($filterFound, self::FIELDS_NAME_THAT_DOES_NOT_BELONG_TO_THE_ENTITY_IN_THE_FILTER_FORM)) {
					$areThereFiltersForPassengers = true;
				}
			}
			
			return $areThereFiltersForPassengers;
		}
	}