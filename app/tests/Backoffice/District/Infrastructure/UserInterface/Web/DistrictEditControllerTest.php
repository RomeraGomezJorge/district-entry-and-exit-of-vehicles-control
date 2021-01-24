<?php
	
	declare(strict_types=1);
	
	namespace App\Tests\Backoffice\District\Infrastructure\UserInterface\Web;
	
	use App\Tests\Backoffice\District\Domain\DistrictMother;
	use App\Tests\Backoffice\District\DistrictInfrastructureTestCase;
	
	final class DistrictEditControllerTest extends DistrictInfrastructureTestCase
	{
		/** @test
		 * Comprueba que se cargue corretamente la interfaz para editar un registro y el funcionamiento de controlador
		 * encargado de actualizar la información.
		 */
		public function it_should_update_a_traffic_police_booth()
		{
			$District = DistrictMother::random();
			
			$this->repository()->save($District);
			
			$client = $this->createAuthorizedClientAdmin();
			
			$crawler = $this->isOnPage($client, self::EDIT_ITEM_PATH . '/' . $District->getId());
			
			$form = $crawler->selectButton('submitBtn')->form();
			
			$form['description'] = $District->getDescription();
			
			$form['id'] = $District->getId();
			
			$client->submit($form);
			
			$this->shouldPageRedirectsTo($client, self::LIST_ITEMS_PATH);
		}
	}