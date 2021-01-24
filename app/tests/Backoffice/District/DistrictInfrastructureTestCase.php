<?php
	
	declare(strict_types=1);
	
	namespace App\Tests\Backoffice\District;
	
	use App\Backoffice\District\Domain\DistrictRepository;
	use App\Tests\Shared\Infrastructure\PhpUnit\ContextInfrastructureTestCase;
	
	class DistrictInfrastructureTestCase extends ContextInfrastructureTestCase
	{
		const LIST_ITEMS_PATH = '/backoffice/district/list';
		const CREATE_ITEM_PATH = '/backoffice/district/create';
		const EDIT_ITEM_PATH = '/backoffice/district/edit';
		const LABEL_TO_CREATE_ITEMS = 'Crear Provincia';
		const LABEL_TO_UPDATE_ITEMS = 'Actualizar Provincia';
		
		protected function repository(): DistrictRepository
		{
			return $this->service(DistrictRepository::class);
		}
	}