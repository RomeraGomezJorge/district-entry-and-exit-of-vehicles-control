<?php
	
	
	namespace App\Tests\Backoffice\User\Infrastructure\UserInterface\Web;
	
	
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Tests\Backoffice\User\UserInfrastructureTestCase;
	
	
	final class UserAddControllerTest extends UserInfrastructureTestCase
	{
	
		private $user;
		
		/** @test
		 * Comprueba que se cargue corretamente la interfaz para crear un registro y el funcionamiento de controlador
		 * encargado de crear la información.
		 */
		public function it_should_create_a_user()
		{
			$client = static::createClient();
			
			$crawler = $client->request('GET', self::CREATE_ITEM_PATH);
			
			$form = $crawler->selectButton('submit')->form();
			
			$form['name'] = $this->user->getName();
			$form['surname'] = $this->user->getSurname();
			$form['email'] = $this->user->getEmail() ;
			$form['password'] = $this->user->getpassword() ;
			$form['role_id'] = $this->user->getrole()->getId() ;
			$form['isActive'] = 'on' ;
			$form['trafficPoliceBooth_id'] = $this->user->gettrafficPoliceBooth()->getId() ;
			
			$client->submit($form);
			
			$this->assertTrue(
				$client->getResponse()->isRedirect(self::LIST_ITEMS_PATH)
			);
			
		}
		
		protected function setUp(): void
		{
			parent::setUp();
			
			$this->user = $this->getUserCreatedForTest();
			
		}
	}