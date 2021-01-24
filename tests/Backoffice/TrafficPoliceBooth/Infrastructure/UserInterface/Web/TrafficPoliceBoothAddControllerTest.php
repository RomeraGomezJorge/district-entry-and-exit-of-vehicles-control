<?php
	
	
	namespace App\Tests\Backoffice\TrafficPoliceBooth\Infrastructure\UserInterface\Web;
	
	use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBooth;
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Tests\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBoothMother;
	use App\Tests\Backoffice\TrafficPoliceBooth\TrafficPoliceBoothInfrastructureTestCase;
	
	final class TrafficPoliceBoothAddControllerTest extends TrafficPoliceBoothInfrastructureTestCase
	{
		private TrafficPoliceBooth $trafficPoliceBooth;
		
		private Uuid $id;
		
		/** @test
		 * Comprueba que se cargue corretamente la interfaz para crear un registro y el funcionamiento de controlador
		 * encargado de crear la información.
		 */
		public function it_should_create_a_traffic_police_booth()
		{
			$client = static::createClient();
			
			$crawler = $client->request('GET', self::CREATE_ITEM_PATH);
			
			$form = $crawler->selectButton('submitBtn')->form();
			
			$form['description'] = $this->trafficPoliceBooth->getDescription();
			
			$client->submit($form);
			
			$this->assertTrue(
				$client->getResponse()->isRedirect(self::LIST_ITEMS_PATH)
			);
			
		}
		
		protected function setUp(): void
		{
			parent::setUp();
			
			$this->trafficPoliceBooth = TrafficPoliceBoothMother::random();
			
			$this->id = new Uuid($this->trafficPoliceBooth->getId());
		}
	}