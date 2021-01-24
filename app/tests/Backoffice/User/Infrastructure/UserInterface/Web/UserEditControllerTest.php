<?php
	
	
	namespace App\Tests\Backoffice\User\Infrastructure\UserInterface\Web;
	
	
	use App\Tests\Backoffice\User\UserInfrastructureTestCase;
	
	final class UserEditControllerTest extends UserInfrastructureTestCase
	{
		private $user;
		
		/** @test
		 * Comprueba que se cargue corretamente la interfaz para editar un registro y el funcionamiento de controlador
		 * encargado de actualizar la información.
		 */
		public function it_should_update_a_user()
		{
			$user = $this->getUserCreatedForTest();
			
			$this->repository()->save($user);
			
			$client = $this->createAuthorizedClientAdmin();
			
			$crawler = $this->isOnPage($client, self::EDIT_ITEM_PATH . '/' . $user->getId());
			
			$form = $crawler->selectButton('submitBtn')->form();
			
			$form['id'] = $user->getId();
			$form['username'] = $user->getUsername();
			$form['name'] = $user->getName();
			$form['surname'] = $user->getSurname();
			$form['email'] = $user->getEmail();
			$form['role_id'] = $user->getrole()->getId();
			$form['is_active'] = 'on';
			$form['traffic_police_booth_id'] = $user->gettrafficPoliceBooth()->getId();
			
			$client->submit($form);
			
			$this->shouldPageRedirectsTo($client, self::LIST_ITEMS_PATH);
			
		}
		
		
	}