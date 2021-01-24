<?php
	
	
	namespace App\Tests\Backoffice\TrafficPoliceBooth\Infrastructure\UserInterface\Web;
	
	use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBooth;
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Tests\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBoothMother;
	use App\Tests\Backoffice\TrafficPoliceBooth\TrafficPoliceBoothInfrastructureTestCase;
	
	final class TrafficPoliceBoothEditControllerTest extends TrafficPoliceBoothInfrastructureTestCase
	{
		/** @test
		 * Comprueba que se cargue corretamente la interfaz para editar un registro y el funcionamiento de controlador
		 * encargado de actualizar la información.
		 */
		public function it_should_update_a_traffic_police_booth()
		{
			$trafficPoliceBooth = TrafficPoliceBoothMother::random();
			
			$this->repository()->save($trafficPoliceBooth);
			
			$client = $this->createAuthorizedClientAdmin();
			
			$crawler = $this->isOnPage($client, self::EDIT_ITEM_PATH . '/' . $trafficPoliceBooth->getId());
			
			$form = $crawler->selectButton('submitBtn')->form();
			
			$form['description'] = $trafficPoliceBooth->getDescription();
			
			$form['id'] = $trafficPoliceBooth->getId();
			
			$client->submit($form);
			
			$this->shouldPageRedirectsTo($client, self::LIST_ITEMS_PATH);
		}
	}