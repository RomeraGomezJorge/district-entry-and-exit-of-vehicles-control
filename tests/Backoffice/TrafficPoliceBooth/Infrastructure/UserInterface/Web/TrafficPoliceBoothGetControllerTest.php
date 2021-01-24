<?php
	
	
	namespace App\Tests\Backoffice\TrafficPoliceBooth\Infrastructure\UserInterface\Web;
	
	use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBooth;
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Tests\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBoothMother;
	use App\Tests\Backoffice\TrafficPoliceBooth\TrafficPoliceBoothInfrastructureTestCase;
	
	
	final class TrafficPoliceBoothGetControllerTest extends TrafficPoliceBoothInfrastructureTestCase
	{
		private TrafficPoliceBooth $trafficPoliceBooth;
		
		private Uuid $id;
		
		/** @test
		 * Comprueba que se cargue correctamente el listado de registros y que los registros generados se encuentren
		 * en el listado.
		 */
		public function it_should_find_traffic_police_booths()
		{
			$anotherTrafficPoliceBooth = TrafficPoliceBoothMother::random();
			$someOtherTrafficPoliceBooth = TrafficPoliceBoothMother::random();
			$this->repository()->save($this->trafficPoliceBooth);
			$this->repository()->save($anotherTrafficPoliceBooth);
			$this->repository()->save($someOtherTrafficPoliceBooth);
			
			$client = static::createClient();
			
			$client->request('GET', self::LIST_ITEMS_PATH);
			
			$this->assertStringContainsString(
				$this->trafficPoliceBooth->getDescription(),
				$client->getResponse()->getContent());
			
			$this->assertStringContainsString(
				$anotherTrafficPoliceBooth->getDescription(),
				$client->getResponse()->getContent());
			
			$this->assertStringContainsString(
				$someOtherTrafficPoliceBooth->getDescription(),
				$client->getResponse()->getContent());
		}
		
		/** @test
		 * Comprueba que se cargue correctamente la interfaz para crear un registro luego del hacer click en el boton
		 * de "Crear" que se encuentra en el listado.
		 */
		public function it_should_show_interface_to_create_a_traffic_police_booth()
		{
			$client = static::createClient();
			
			$crawler = $client->request('GET', self::LIST_ITEMS_PATH);
			
			$createItemLink = $crawler->filter('a#createItemLink')->link();
			
			$crawler = $client->click($createItemLink);
			
			$this->assertTrue($crawler->filter('html:contains("'.self::LABEL_TO_CREATE_ITEMS.'")')->count() > 0);
		}
		
		/** @test
		 * Solo se comprueba la url con un filtro ya aplicado porque el envio de los filtros se realiza con javascript
		 */
		public function it_should_find_traffic_police_booths_by_criteria()
		{
			$anotherTrafficPoliceBooth = TrafficPoliceBoothMother::random();
			$this->repository()->save($this->trafficPoliceBooth);
			$this->repository()->save($anotherTrafficPoliceBooth);
			
			$client = static::createClient();
			
			$client->request(
				'GET',
				self::LIST_ITEMS_PATH.'/page-1/order-createAt-desc/rows_per_page-10/filters%5B0%5D%5Bfield%5D=description&filters%5B0%5D%5Boperator%5D=%3D&filters%5B0%5D%5Bvalue%5D=' . $anotherTrafficPoliceBooth->getDescription());
			
			$this->assertStringNotContainsString(
				$this->trafficPoliceBooth->getDescription(),
				$client->getResponse()->getContent()
			);
		}
		
		/** @test
		 * Comprueba que se cargue correctamente la interfaz para editar un registro luego del hacer click en el boton
		 * de editar que se encuentra en el listado
		 */
		public function it_should_show_interface_to_edit_a_traffic_police_booth()
		{
			$this->repository()->save($this->trafficPoliceBooth);
			
			$client = static::createClient();
			
			$crawler = $client->request('GET', self::LIST_ITEMS_PATH);
			
			$createItemLink = $crawler->filter('a.editItemLink')->link();
			
			$crawler = $client->click($createItemLink);
			
			$this->assertTrue($crawler->filter('html:contains("'.self::LABEL_TO_UPDATE_ITEMS.'")')->count() > 0);
			
		}
		
		protected function setUp(): void
		{
			parent::setUp();
			
			$this->trafficPoliceBooth = TrafficPoliceBoothMother::random();
			
			$this->id = new Uuid($this->trafficPoliceBooth->getId());
		}
	}