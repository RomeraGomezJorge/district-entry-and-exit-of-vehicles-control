<?php
	
	declare(strict_types=1);
	
	namespace App\Tests\Backoffice\District\Infrastructure\UserInterface\Web;
	
	use App\Backoffice\District\Domain\District;
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Tests\Backoffice\District\Domain\DistrictMother;
	use App\Tests\Backoffice\District\DistrictInfrastructureTestCase;
	
	final class DistrictAddControllerTest extends DistrictInfrastructureTestCase
	{
		/** @test
		 * Comprueba que se cargue corretamente la interfaz para crear un registro y el funcionamiento de controlador
		 * encargado de crear la información.
		 */
		public function it_should_create_a_traffic_police_booth()
		{
			$District = DistrictMother::random();
			
			$client = $this->createAuthorizedClientAdmin();
			
			$crawler = $this->isOnPage($client, self::CREATE_ITEM_PATH);
			
			$form = $crawler->selectButton('submitBtn')->form();
			
			$form['description'] = $District->getDescription();
			
			$client->submit($form);
			
			$this->shouldPageRedirectsTo($client, self::LIST_ITEMS_PATH);
		}
	}