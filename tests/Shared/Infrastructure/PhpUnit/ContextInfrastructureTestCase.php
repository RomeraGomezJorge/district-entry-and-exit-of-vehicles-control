<?php
	
	declare(strict_types=1);
	
	namespace App\Tests\Shared\Infrastructure\PhpUnit;
	
	use App\Backoffice\Role\Domain\Role;
	use App\Backoffice\Role\Domain\RoleRepository;
	use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBoothRepository;
	use App\Backoffice\User\Domain\User;
	use App\Backoffice\User\Domain\UserRepository;
	use App\Kernel;
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Tests\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBoothMother;
	use App\Tests\Backoffice\User\Domain\UserMother;
	use Doctrine\ORM\EntityManager;
	use Symfony\Component\BrowserKit\Cookie;
	use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
	
	
	abstract class ContextInfrastructureTestCase extends InfrastructureTestCase
	{
		protected function setUp(): void
		{
			parent::setUp();
			
			$kernel = self::bootKernel();
			
			$entityManager = $kernel->getContainer()
				->get('doctrine')
				->getManager();
			
			$arranger = new BlogEnvironmentArranger($this->service(EntityManager::class));
			
			$arranger->arrange();
		}
		
		protected function tearDown(): void
		{
			$arranger = new BlogEnvironmentArranger($this->service(EntityManager::class));
			
			$arranger->close();
			
			parent::tearDown();
		}
		
		protected function kernelClass(): string
		{
			return Kernel::class;
		}
		
		public static function generateClient()
		{
			self::ensureKernelShutdown();
			
			return static::createClient();
		}
		
		public function isOnPage($client, $page)
		{
			return $client->request('GET', $page);
		}
		
		public function shouldPageRedirectsTo($client, $route)
		{
			$this->assertTrue(
				$client->getResponse()->isRedirect($route)
			);
		}
		
		public function shouldFindOnThePage($client, $contentToFind)
		{
			$this->assertStringContainsString(
				$contentToFind,
				$client->getResponse()->getContent()
			);
		}
		
		public function clickAndFollowTheLink($client, $crawler, $linkSelector)
		{
			$createItemLink = $crawler->filter($linkSelector)->link();
			
			return $client->click($createItemLink);
		}
		
		
		protected function userRepository(): UserRepository
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
		
		
		protected function getUserCreatedForTest(): User
		{
			$trafficPoliceBooth = TrafficPoliceBoothMother::random();
			
			$this->trafficPoliceBoothRepository()->save($trafficPoliceBooth);
			
			$this->clearUnitOfWork();
			
			$this->roleFound = $this->getARoleFromDatabase();
			
			$this->trafficPoliceBoothFound = $this->trafficPoliceBoothRepository()->search(new Uuid($trafficPoliceBooth->getId()));
			
			return UserMother::randomWithARoleAndTrafficPoliceBooth($this->roleFound, $this->trafficPoliceBoothFound);
		}
		
		
		/** Crea un usuario en la tabla user de la base de datos y simula que este usuario esta autenticado*/
		protected function createAuthorizedClient()
		{
			$client = static::createClient();
			
			$container = static::$kernel->getContainer();
			
			$session = $container->get('session');
			
			$person = $this->getUserCreatedForTest();
			
			$this->userRepository()->save($person);
			
			$token = new UsernamePasswordToken($person, null, 'main', $person->getRoles());
			
			$session->set('_security_main', serialize($token));
			
			$session->save();
			
			$client->getCookieJar()->set(new Cookie($session->getName(), $session->getId()));
			
			return $client;
		}
		
		/** Comprueba que el rol generado aleatoriamente ya ha sido creado, si esto sucede lo busca y lo retorana
		 * caso contrario los crea y lo retorna
		 */
		
		protected function getARoleFromDatabase(): Role
		{
			$role = UserMother::createRandomRole();
			
			$isRoleAlreadyCreated = $this->roleRepository()->search($role->getId());
			
			if (!is_null($isRoleAlreadyCreated)) {
				
				return $isRoleAlreadyCreated;
			}
			
			$this->roleRepository()->save($role);
			
			$this->clearUnitOfWork();
			
			return $this->roleRepository()->search($role->getId());
		}
		
		
	}
