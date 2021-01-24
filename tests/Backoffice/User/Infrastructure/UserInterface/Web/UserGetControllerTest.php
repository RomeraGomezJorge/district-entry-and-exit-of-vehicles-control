<?php
	
	
	namespace App\Tests\Backoffice\User\Infrastructure\UserInterface\Web;
	
	
	use App\Tests\Backoffice\User\Domain\UserMother;
	use App\Tests\Backoffice\User\UserInfrastructureTestCase;
	
	final class UserGetControllerTest extends UserInfrastructureTestCase
	{
		private  $user;
		
		/** @test
		 * Comprueba que se cargue correctamente el listado de registros y que los registros generados se encuentren
		 * en el listado.
		 */
		public function it_should_find_user()
		{
			$anotherTrafficPoliceBooth = UserMother::randomWithARoleAndTrafficPoliceBooth($this->roleFound, $this->trafficPoliceBoothFound);
			$someOtherTrafficPoliceBooth = UserMother::randomWithARoleAndTrafficPoliceBooth($this->roleFound, $this->trafficPoliceBoothFound);
			
			$this->repository()->save($anotherTrafficPoliceBooth);
			$this->repository()->save($someOtherTrafficPoliceBooth);
			
			$client = static::createClient();
			
			$client->request('GET', self::LIST_ITEMS_PATH);
			
			$this->assertStringContainsString(
				$this->user->getUsername(),
				$client->getResponse()->getContent());
			
			$this->assertStringContainsString(
				$anotherTrafficPoliceBooth->getEmail(),
				$client->getResponse()->getContent());
			
			$this->assertStringContainsString(
				$someOtherTrafficPoliceBooth->getName(),
				$client->getResponse()->getContent());
		}
		
		/** @test
		 * Comprueba que se cargue correctamente la interfaz para crear un registro luego del hacer click en el boton
		 * de "Crear" que se encuentra en el listado.
		 */
		public function it_should_show_interface_to_create_a_user()
		{
			$client = static::createClient();
			
			$crawler = $client->request('GET', self::LIST_ITEMS_PATH);
			
			$createItemLink = $crawler->filter('a#createItemLink')->link();
			
			$crawler = $client->click($createItemLink);
			
			$this->assertTrue($crawler->filter('html:contains("' . self::LABEL_TO_CREATE_ITEMS . '")')->count() > 0);
		}
		
		/** @test
		 * Solo se comprueba la url con un filtro ya aplicado porque el envio de los filtros se realiza con javascript
		 */
		public function it_should_find_user_by_criteria()
		{
			$fieldByField = 'username';
			
			$anotherUser = UserMother::randomWithARoleAndTrafficPoliceBooth($this->roleFound, $this->trafficPoliceBoothFound);
			$this->repository()->save($this->user);
			$this->repository()->save($anotherUser);
			
			$client = static::createClient();
			
			$client->request(
				'GET',
				self::LIST_ITEMS_PATH . '/page-1/order-createAt-desc/rows_per_page-10/filters%5B0%5D%5Bfield%5D='.$fieldByField.'&filters%5B0%5D%5Boperator%5D=%3D&filters%5B0%5D%5Bvalue%5D=' . $anotherUser->getUsername());
			
			$this->assertStringNotContainsString(
				$this->user->getName(),
				$client->getResponse()->getContent()
			);
		}
		
		/** @test
		 * Comprueba que se cargue correctamente la interfaz para editar un registro luego del hacer click en el boton
		 * de editar que se encuentra en el listado
		 */
		public function it_should_show_interface_to_edit_a_user()
		{
			$client = static::createClient();
			
			$crawler = $client->request('GET', self::LIST_ITEMS_PATH);
			
			$createItemLink = $crawler->filter('a.editItemLink')->link();
			
			$crawler = $client->click($createItemLink);
			
			$this->assertTrue($crawler->filter('html:contains("' . self::LABEL_TO_UPDATE_ITEMS . '")')->count() > 0);
			
		}
		
		protected function setUp(): void
		{
			parent::setUp();
			
			$this->user = $this->getUserCreatedForTest();
			
			$this->repository()->save($this->user);
		}
	}