<?php
	
	
	namespace App\Tests\Backoffice\User\Infrastructure\UserInterface\Web;
	
	
	use App\Tests\Backoffice\User\Domain\UserMother;
	use App\Tests\Backoffice\User\UserInfrastructureTestCase;
	
	final class UserGetControllerTest extends UserInfrastructureTestCase
	{
		private $user;
		/**
		 * @var \Symfony\Bundle\FrameworkBundle\KernelBrowser
		 */
		private $client;
		
		protected function setUp(): void
		{
			parent::setUp();
			
			$this->user = $this->getUserCreatedForTest();
			
			$this->repository()->save($this->user);
			
			$this->client = $this->createAuthorizedClient();
			
		}
		
		/** @test
		 * Comprueba que se cargue correctamente el listado de registros y que los registros generados se encuentren
		 * en el listado.
		 */
		public function it_should_find_user()
		{
			$anotherTrafficPoliceBooth = UserMother::randomWithARoleAndTrafficPoliceBooth(
				$this->roleFound,
				$this->trafficPoliceBoothFound
			);
			
			$someOtherTrafficPoliceBooth = UserMother::randomWithARoleAndTrafficPoliceBooth(
				$this->roleFound,
				$this->trafficPoliceBoothFound
			);
			
			$this->repository()->save($anotherTrafficPoliceBooth);
			$this->repository()->save($someOtherTrafficPoliceBooth);
			$this->clearUnitOfWork();
			
			$this->isOnPage($this->client, self::LIST_ITEMS_PATH);
			
			$this->shouldFindOnThePage($this->client, $this->user->getUsername());
			
			$this->shouldFindOnThePage($this->client, $anotherTrafficPoliceBooth->getEmail());
			
			$this->shouldFindOnThePage($this->client, $someOtherTrafficPoliceBooth->getName());
		}
		
		/** @test
		 * Comprueba que se cargue correctamente la interfaz para crear un registro luego del hacer click en el boton
		 * de "Crear" que se encuentra en el listado.
		 */
		public function it_should_show_interface_to_create_a_user()
		{
			$crawler = $this->isOnPage($this->client, self::LIST_ITEMS_PATH);
			
			$this->clickAndFollowTheLink($this->client, $crawler, 'a#createItemLink');
			
			$this->shouldFindOnThePage($this->client, self::LABEL_TO_CREATE_ITEMS);
		}
		
		/** @test
		 * Solo se comprueba la url con un filtro ya aplicado porque el envio de los filtros se realiza con javascript
		 */
		public function it_should_find_user_by_criteria()
		{
			$fieldByField = 'username';
			
			$anotherUser = UserMother::randomWithARoleAndTrafficPoliceBooth(
				$this->roleFound,
				$this->trafficPoliceBoothFound
			);
			
			$this->repository()->save($anotherUser);
			$this->clearUnitOfWork();
			
			$this->isOnPage(
				$this->client,
				self::LIST_ITEMS_PATH . '/page-1/order-createAt-desc/rows_per_page-10/filters%5B0%5D%5Bfield%5D=' . $fieldByField . '&filters%5B0%5D%5Boperator%5D=%3D&filters%5B0%5D%5Bvalue%5D=' . $anotherUser->getUsername()
			);
			
			$this->shouldFindOnThePage($this->client, $anotherUser->getUsername());
		}
		
		/** @test
		 * Comprueba que se cargue correctamente la interfaz para editar un registro luego del hacer click en el boton
		 * de editar que se encuentra en el listado
		 */
		public function it_should_show_interface_to_edit_a_user()
		{
			$crawler = $this->isOnPage($this->client, self::LIST_ITEMS_PATH);
			
			$this->clickAndFollowTheLink($this->client, $crawler, 'a.editItemLink');
			
			$this->shouldFindOnThePage($this->client, self::LABEL_TO_UPDATE_ITEMS);
		}

	}