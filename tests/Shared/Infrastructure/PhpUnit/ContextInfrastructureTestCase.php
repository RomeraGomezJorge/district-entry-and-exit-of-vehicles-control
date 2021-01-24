<?php
	
	declare(strict_types=1);
	
	namespace App\Tests\Shared\Infrastructure\PhpUnit;
	
	use App\Kernel;
	use Doctrine\ORM\EntityManager;
	
	
	abstract class ContextInfrastructureTestCase extends InfrastructureTestCase
	{
		protected function setUp(): void
		{
			parent::setUp();
			
			$kernel = self::bootKernel();
			
			$entityManager = $kernel->getContainer()
				->get('doctrine')
				->getManager();
			
			$arranger = new BlogEnvironmentArranger($this->service(EntityManager::class));
			
			$arranger->arrange();
		}
		
		protected function tearDown(): void
		{
			$arranger = new BlogEnvironmentArranger($this->service(EntityManager::class));
			
			$arranger->close();
			
			parent::tearDown();
		}
		
		protected function kernelClass(): string
		{
			return Kernel::class;
		}
		
		public static function generateClient()
		{
			self::ensureKernelShutdown();
			
			return static::createClient();
		}
	}
