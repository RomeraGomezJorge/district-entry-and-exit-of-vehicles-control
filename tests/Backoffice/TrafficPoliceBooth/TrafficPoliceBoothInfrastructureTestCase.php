<?php
	
	
	namespace App\Tests\Backoffice\TrafficPoliceBooth;
	
	
	
	use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBoothRepository;
	use App\Tests\Shared\Infrastructure\PhpUnit\ContextInfrastructureTestCase;
	
	class TrafficPoliceBoothInfrastructureTestCase extends ContextInfrastructureTestCase
	{
	
		const LIST_ITEMS_PATH = '/backoffice/traffic_police_booth/list';
		const CREATE_ITEM_PATH = '/backoffice/traffic_police_booth/create';
		const EDIT_ITEM_PATH = '/backoffice/traffic_police_booth/edit';
		const LABEL_TO_CREATE_ITEMS = 'Crear Puesto de Control';
		const LABEL_TO_UPDATE_ITEMS = 'Actualizar Puesto de Control';
		
		protected function repository(): TrafficPoliceBoothRepository
		{
			return $this->service(TrafficPoliceBoothRepository::class);
		}
	}