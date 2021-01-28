<?php
	
	
	namespace App\Tests\Backoffice\User\Infrastructure\UserInterface\Web;
	
	
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Tests\Backoffice\User\Domain\UserMother;
	use App\Tests\Backoffice\User\UserInfrastructureTestCase;
	use Symfony\Component\BrowserKit\Cookie;
	use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
	
	
	final class UserAddControllerTest extends UserInfrastructureTestCase
	{
		
		private $user;
		/**
		 * @var \Symfony\Bundle\FrameworkBundle\KernelBrowser
		 */
		private $client;
		
		/** @test
		 * Comprueba que se cargue corretamente la interfaz para crear un registro y el funcionamiento de controlador
		 * encargado de crear la información.
		 */
		public function it_should_create_a_user()
		{
			$user = $this->getUserCreatedForTest();
			
			$client = $this->createAuthorizedClient();
			
			$crawler = $this->isOnPage($client, self::CREATE_ITEM_PATH);
			
			$form = $crawler->selectButton('submitBtn')->form();
			
			$form['username'] = $user->getUsername();
			$form['name'] = $user->getName();
			$form['surname'] = $user->getSurname();
			$form['email'] = $user->getEmail();
			$form['password'] = $user->getpassword();
			$form['role_id'] = $user->getrole()->getId();
			$form['isActive'] = 'on';
			$form['trafficPoliceBooth_id'] = $user->gettrafficPoliceBooth()->getId();
			
			$client->submit($form);
			
			$this->shouldPageRedirectsTo($client, self::LIST_ITEMS_PATH);
			
		}
		
	}