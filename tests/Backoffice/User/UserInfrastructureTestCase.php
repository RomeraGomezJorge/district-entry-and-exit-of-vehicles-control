<?php
	
	namespace App\Tests\Backoffice\User;
	
	
	use App\Backoffice\Role\Domain\Role;
	use App\Backoffice\Role\Domain\RoleRepository;
	use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBooth;
	use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBoothRepository;
	use App\Backoffice\User\Domain\User;
	use App\Backoffice\User\Domain\UserRepository;
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Tests\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBoothMother;
	use App\Tests\Backoffice\User\Domain\UserMother;
	use App\Tests\Shared\Infrastructure\PhpUnit\ContextInfrastructureTestCase;
	use http\Env\Request;
	use Symfony\Component\BrowserKit\Cookie;
	use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
	
	class UserInfrastructureTestCase extends ContextInfrastructureTestCase
	{
		protected Role $roleFound;
		protected TrafficPoliceBooth $trafficPoliceBoothFound;
		const LIST_ITEMS_PATH = '/backoffice/user/list';
		const CREATE_ITEM_PATH = '/backoffice/user/create';
		const EDIT_ITEM_PATH = '/backoffice/user/edit';
		const LABEL_TO_CREATE_ITEMS = 'Crear Usuarios';
		const LABEL_TO_UPDATE_ITEMS = 'Actualizar Usuarios';
		
		protected function repository(): UserRepository
		{
			return $this->service(UserRepository::class);
		}
		
		protected function roleRepository(): RoleRepository
		{
			return $this->service(RoleRepository::class);
		}
		
		protected function trafficPoliceBoothRepository(): TrafficPoliceBoothRepository
		{
			return $this->service(TrafficPoliceBoothRepository::class);
		}
		
		/** Crea un usuario en la tabla user de la base de datos*/
		protected function getUserCreatedForTest(): User
		{
			$trafficPoliceBooth = TrafficPoliceBoothMother::random();
			
			$this->trafficPoliceBoothRepository()->save($trafficPoliceBooth);
			
			$this->clearUnitOfWork();
			
			$this->roleFound = $this->getARoleFromDatabase();
			
			$this->trafficPoliceBoothFound = $this->trafficPoliceBoothRepository()->search(new Uuid($trafficPoliceBooth->getId()));
			
			return UserMother::randomWithARoleAndTrafficPoliceBooth($this->roleFound, $this->trafficPoliceBoothFound);
		}
		
	}