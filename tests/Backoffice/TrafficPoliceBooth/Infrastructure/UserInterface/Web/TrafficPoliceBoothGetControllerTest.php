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
		/**
		 * @var \Symfony\Bundle\FrameworkBundle\KernelBrowser
		 */
		private $client;
		
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
			
			$this->client = $this->createAuthorizedClient();
			
			$this->isOnPage($this->client, self::LIST_ITEMS_PATH);
			
			$this->shouldFindOnThePage(
				$this->client,
				$this->trafficPoliceBooth->getDescription()
			);
			
			$this->shouldFindOnThePage(
				$this->client,
				$anotherTrafficPoliceBooth->getDescription()
			);
			
			$this->shouldFindOnThePage(
				$this->client,
				$someOtherTrafficPoliceBooth->getDescription()
			);
		}
		
		/** @test
		 * Comprueba que se cargue correctamente la interfaz para crear un registro luego del hacer click en el boton
		 * de "Crear" que se encuentra en el listado.
		 */
		public function it_should_show_interface_to_create_a_traffic_police_booth()
		{
			$crawler = $this->isOnPage($this->client, self::LIST_ITEMS_PATH);
			
			$this->clickAndFollowTheLink($this->client, $crawler, 'a#createItemLink');
			
			$this->shouldFindOnThePage($this->client, self::LABEL_TO_CREATE_ITEMS);
		}
		
		/** @test
		 * Solo se comprueba la url con un filtro ya aplicado porque el envio de los filtros se realiza con javascript
		 */
		public function it_should_find_traffic_police_booths_by_criteria()
		{
			$anotherTrafficPoliceBooth = TrafficPoliceBoothMother::random();
			$this->repository()->save($this->trafficPoliceBooth);
			$this->repository()->save($anotherTrafficPoliceBooth);
			
			$this->isOnPage(
				$this->client,
				self::LIST_ITEMS_PATH . '/page-1/order-createAt-desc/rows_per_page-10/filters%5B0%5D%5Bfield%5D=description&filters%5B0%5D%5Boperator%5D=%3D&filters%5B0%5D%5Bvalue%5D=' . $anotherTrafficPoliceBooth->getDescription()
			);
			
			$this->shouldFindOnThePage(
				$this->client,
				$anotherTrafficPoliceBooth->getDescription()
			);
		}
		
		/** @test
		 * Comprueba que se cargue correctamente la interfaz para editar un registro luego del hacer click en el boton
		 * de editar que se encuentra en el listado
		 */
		public function it_should_show_interface_to_edit_a_traffic_police_booth()
		{
			$this->repository()->save($this->trafficPoliceBooth);
			
			$crawler = $this->isOnPage($this->client, self::LIST_ITEMS_PATH);
			
			$this->clickAndFollowTheLink($this->client, $crawler, 'a.editItemLink');
			
			$this->shouldFindOnThePage($this->client, self::LABEL_TO_UPDATE_ITEMS);
		}
		
		protected function setUp(): void
		{
			parent::setUp();
			
			$this->trafficPoliceBooth = TrafficPoliceBoothMother::random();
			
			$this->id = new Uuid($this->trafficPoliceBooth->getId());
			
			$this->client = $this->createAuthorizedClient();
		}
	}