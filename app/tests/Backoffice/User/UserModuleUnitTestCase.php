<?php
	
	declare(strict_types=1);
	
	namespace App\Tests\Backoffice\User;
	
	
	use App\Backoffice\Role\Domain\Role;
	use App\Backoffice\Role\Domain\RoleRepository;
	use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBooth;
	use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBoothRepository;
	use App\Backoffice\User\Domain\PasswordEncoder;
	use App\Backoffice\User\Domain\UniqueUserEmailSpecification;
	use App\Backoffice\USer\Domain\UniqueUserNameSpecification;
	use App\Backoffice\USer\Domain\User;
	use App\Backoffice\USer\Domain\UserRepository;
	use App\Shared\Domain\Bus\Event\EventBus;
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
	
	
	abstract class UserModuleUnitTestCase extends UnitTestCase
	{
		protected $repository;
		protected $uniqueUserNameSpecification;
		protected $uniqueUserEmailSpecification;
		protected $bus;
		private $passwordEncoder;
		private $roleRepository;
		private $trafficPoliceBoothRepository;
		
		protected function repository(): UserRepository
		{
			return $this->repository = $this->repository ?: $this->mock(UserRepository::class);
		}
		
		protected function roleRepository(): RoleRepository
		{
			return $this->roleRepository = $this->roleRepository ?: $this->mock(RoleRepository::class);
		}
		
		protected  function trafficPoliceBoothRepository():TrafficPoliceBoothRepository
		{
			return $this->trafficPoliceBoothRepository = $this->trafficPoliceBoothRepository ?: $this->mock(TrafficPoliceBoothRepository::class);
		}
		
		protected function uniqueUserNameSpecification(): UniqueUserNameSpecification
		{
			return $this->uniqueUserNameSpecification = $this->uniqueUserNameSpecification ?: $this->mock(UniqueUserNameSpecification::class);
		}
		
		protected function uniqueUserEmailSpecification(): UniqueUserEmailSpecification
		{
			return $this->uniqueUserEmailSpecification = $this->uniqueUserEmailSpecification ?: $this->mock(UniqueUserEmailSpecification::class);
		}
		
		protected function passwordEncoder(): PasswordEncoder
		{
			return $this->passwordEncoder = $this->passwordEncoder ?: $this->mock(PasswordEncoder::class);
		}
		
		protected function bus(): EventBus
		{
			return $this->bus = $this->bus ?: $this->mock(EventBus::class);
		}
		
		public function shouldBeAnUniqueUserName(string $username): void
		{
			$this->uniqueUserNameSpecification()
				->shouldReceive('isSatisfiedBy')
				->once()
				->with($username)
				->andReturn(true);
		}
		
		public function shouldBeNonUniqueUserName(string $UserName): void
		{
			$this->uniqueUserNameSpecification()
				->shouldReceive('isSatisfiedBy')
				->once()
				->with($UserName)
				->andReturn(false);
		}
		
		public function shouldBeAnUniqueEmail(string $email): void
		{
			$this->uniqueUserEmailSpecification()
				->shouldReceive('isSatisfiedBy')
				->once()
				->with($email)
				->andReturn(true);
		}
		
		public function shouldBeNonUniqueEmail(string $email): void
		{
			$this->uniqueUserEmailSpecification()
				->shouldReceive('isSatisfiedBy')
				->once()
				->with($email)
				->andReturn(false);
		}
		
		protected function shouldFind(string $id, User $author): void
		{
			$id = new Uuid($id);
			$this->repository()
				->shouldReceive('search')
				->once()
				->with($this->similarTo($id))
				->andReturn($author);
		}
		
		protected function shouldNotFind($id): void
		{
			$id = new Uuid($id);
			
			$this->repository()
				->shouldReceive('search')
				->once()
				->with($this->similarTo($id))
				->andReturnNull();
		}
		
		/** Debe buscar el rol con el id enviado por parametro al menos una vez y encontrarlo por lo tanto retornaria
		 * el rol enviado como segundo parametro.
		 */
		protected function shouldFindARole(string $id, Role $role): void
		{
			$this->roleRepository()
				->shouldReceive('search')
				->once()
				->with($this->similarTo($id))
				->andReturn($role);
		}
		
		/** Debe buscar el rol con el id enviado por parametro al menos una vez y retornar NULL ya que no lo encontro.*/
		protected function shouldNotFindARole(string $roleId): void
		{
			$this->roleRepository()
				->shouldReceive('search')
				->once()
				->with($roleId)
				->andReturnNull();
		}
		
		/** Deberia buscar el puesto de control con el id enviado por parametro al menos una vez y encontrarlo por lo tanto
		 * retornaria el puesto de control enviado en le segundo parametro.
		 */
		protected function shouldFindATrafficPoliceBooth(string $id, TrafficPoliceBooth $trafficPoliceBooth): void
		{
			$this->trafficPoliceBoothRepository()
				->shouldReceive('search')
				->once()
				->with($this->similarTo($id))
				->andReturn($trafficPoliceBooth);
		}
		
		/** Deberia buscar el puesto de control con el id enviado por parametro al menos una vez y retornar NULL
		 * ya que no lo encontro.
		 */
		protected function shouldNotFindATrafficPoliceBooth($roleId): void
		{
			
			
			$this->trafficPoliceBoothRepository()
				->shouldReceive('search')
				->once()
				->with($this->similarTo($roleId))
				->andReturnNull();
		}
		
		/** Deberia guarda el user enviado por parametro al menos una vez */
		protected function shouldSave(User $user): void
		{
			$this->repository()
				->shouldReceive('save')
				->once()
				->with($this->similarTo($user))
				->andReturnNull();
		}
		
		
		/** No deberia llamar al metodo para guardar datos */
		protected function shouldNotSave()
		{
			$this->repository()
				->shouldReceive('save')
				->never();
		}
		
		/**Deberia publicar los eventos de dominio */
		protected function shouldPublish()
		{
			$this->bus()
				->shouldReceive('publish')
				->once();
		}
		
		/** No deberia publicar los eventos de dominio */
		protected function shouldNotPublish()
		{
			$this->bus()
				->shouldReceive('publish')
				->never();
		}
		
		protected function shouldEncodePassword(User $user, string $password)
		{
			$this->passwordEncoder()->shouldReceive('encode')->with($this->similarTo($user),$password)->andReturn($password);
				
		}
	}
