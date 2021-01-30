<?php
	
	
	namespace App\Backoffice\ModelOfVehicle\Application\Counter;
	
	
	use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicleRepository;
	use App\Backoffice\VehicleMakerName\Application\Find\VehicleMakerNameFinder;
	use App\Backoffice\VehicleMakerName\Domain\VehicleMakerName;
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\Criteria\Filters;
	use App\Shared\Domain\Criteria\Order;
	use App\Shared\Infrastructure\Utils\FilterUtilsForFieldThatNotBelongToAnEntity;
	
	final class ModelOfVehicleCounter
	{
		const FIELD_NAME_THAT_DOES_NOT_BELONG_TO_THE_ENTITY_IN_THE_FILTER_FORM = 'vehicleMakerName';
		private ModelOfVehicleRepository $repository;
		private VehicleMakerNameFinder $finderVehicleMakerName;
		
		public function __construct(ModelOfVehicleRepository $repository)
		{
			$this->repository = $repository;
		}
		
		public function __invoke($filters, $order, $orderBy, ?int $limit, ?int $offset): int
		{
			$vehicleMakerName = $this->getVehicleMakerNameFromFilter($filters);
			
			$filters = Filters::fromValues(
				$this->removeFiltersThatNotBelongToPostEntity($filters)
			);
			
			$order = Order::fromValues($order, $orderBy);
			
			$criteria = new Criteria($filters, $order, $offset, $limit);
			
			return $this->repository->totalMatchingRows($criteria, $vehicleMakerName);
		}
		
		/** Obtiene una entidad del tipo marca de vehiculo en caso que se aplique este filtro */
		private function getVehicleMakerNameFromFilter(array $filters): ?VehicleMakerName
		{
			/* Verifica si en el arreglo de "$filtres" esta definido el campo  "self::FIELD_NAME_IN_FILTERS_TO_VEHICLE_MAKER_NAME" */
			if (!FilterUtilsForFieldThatNotBelongToAnEntity::isDefineAsFilter(
				$filters,
				self::FIELD_NAME_THAT_DOES_NOT_BELONG_TO_THE_ENTITY_IN_THE_FILTER_FORM)) {
				return null;
			};
			
			/* Obtiene el valor asignado para el campo "self::FIELD_NAME_IN_FILTERS_TO_VEHICLE_MAKER_NAME" en el arreglo "$filters" */
			$vehicleMakerNameId = FilterUtilsForFieldThatNotBelongToAnEntity::getValueFromFilters(
				$filters,
				self::FIELD_NAME_THAT_DOES_NOT_BELONG_TO_THE_ENTITY_IN_THE_FILTER_FORM
			);
			
			/*En caso que el valor asignado en el campo "self::FIELD_NAME_IN_FILTERS_TO_VEHICLE_MAKER_NAME" sea un
			id valido  retorna la entidad asignada para ese id */
			return $this->finderVehicleMakerName->__invoke($vehicleMakerNameId);
		}
		
		/** Remueve del arreglo $filtres todos los campos que no le correspondan a la entidad ModelOfVehicle */
		private function removeFiltersThatNotBelongToPostEntity($filters): array
		{
			return FilterUtilsForFieldThatNotBelongToAnEntity::removeFilter($filters,
				self::FIELD_NAME_THAT_DOES_NOT_BELONG_TO_THE_ENTITY_IN_THE_FILTER_FORM);
		}
		
	}