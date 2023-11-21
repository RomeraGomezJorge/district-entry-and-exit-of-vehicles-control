<?php
	
	declare(strict_types=1);
	
	namespace App\Tests\Backoffice\District\Infrastructure\Persistence;
	
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Tests\Backoffice\District\Domain\DistrictMother;
	use App\Backoffice\District\Domain\District;
	use App\Tests\Backoffice\District\DistrictInfrastructureTestCase;
	use App\Tests\Shared\Domain\Criteria\CriteriaMother;
	
	
	final class MySqlDistrictRepositoryTest extends DistrictInfrastructureTestCase
	{
		private District $District;
		private Uuid $id;
		
		protected function setUp(): void
		{
			parent::setUp(); // TODO: Change the autogenerated stub
			
			$this->District = DistrictMother::random();
			
			$this->id = new Uuid($this->District->getId());
		}
		
		/** @test */
		public function it_should_save_a_district(): void
		{
			$this->repository()->save($this->District);
			
			$this->clearUnitOfWork();
			
			$this->assertNotNull($this->repository()->search($this->id));
		}
		
		/** @test */
		public function it_should_return_an_existing_district(): void
		{
			$this->repository()->save($this->District);
			
			$this->clearUnitOfWork();
			
			$tagFound = $this->repository()->search($this->id);
			
			$this->assertNull(
				$this->assertSimilar($this->District, $tagFound)
			);
		}
		
		/** @test */
		public function it_should_not_return_a_non_existing_district(): void
		{
			$this->assertNull(
				$this->repository()->search($this->id)
			);
		}
		
		/** @test */
		public function it_should_delete_an_existing_author()
		{
			$this->repository()->save($this->District);
			
			$this->clearUnitOfWork();
			
			$itemFound = $this->repository()->search($this->id);
			
			$this->assertNull(
				$this->repository()->delete($itemFound)
			);
		}
		
		/** @test */
		public function it_should_search_all_existing_author(): void
		{
			$existingAuthor = DistrictMother::random();
			$anotherExistingAuthor = DistrictMother::random();
			$existingAuthors = [$existingAuthor, $anotherExistingAuthor];
			
			$this->repository()->save($existingAuthor);
			$this->repository()->save($anotherExistingAuthor);
			$this->clearUnitOfWork();
			
			$this->assertEquals(
				count($existingAuthors),
				count($this->repository()->searchAll())
			);
		}
		
		/** @test */
		public function it_should_search_all_existing_authors_with_an_empty_criteria(): void
		{
			$existingItem = DistrictMother::random();
			$anotherExistingItem = DistrictMother::random();
			$existingItems = [$existingItem, $anotherExistingItem];
			
			$this->repository()->save($existingItem);
			$this->repository()->save($anotherExistingItem);
			$this->clearUnitOfWork();
			
			$this->assertEquals(
				count($existingItems),
				count($this->repository()->matching(CriteriaMother::empty()))
			);
		}
		
		/** @test */
		public function it_should_filter_by_criteria(): void
		{
			$dddInPhpItem = DistrictMother::randomWithDescription('DDD en PHP');
			$dddInJavaItem = DistrictMother::randomWithDescription('DDD en Java');
			$intellijItem = DistrictMother::randomWithDescription('Exprimiendo Intellij');
			$dddAuthors = [$dddInPhpItem, $dddInJavaItem];
			
			$fullNameContainsDddCriteria = CriteriaMother::contains('description', 'DDD');
			
			$this->repository()->save($dddInJavaItem);
			$this->repository()->save($dddInPhpItem);
			$this->repository()->save($intellijItem);
			$this->clearUnitOfWork();
			
			$this->assertEquals(
				count($dddAuthors),
				count($this->repository()->matching($fullNameContainsDddCriteria))
			);
		}
	}