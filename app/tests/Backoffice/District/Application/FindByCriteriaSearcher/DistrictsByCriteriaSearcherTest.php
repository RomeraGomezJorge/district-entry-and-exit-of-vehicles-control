<?php
	declare(strict_types=1);
	
	namespace App\Tests\Backoffice\District\Application\FindByCriteriaSearcher;
	
	use App\Backoffice\District\Application\FindByCriteriaSearcher\DistrictsByCriteriaSearcher;
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\Criteria\Filters;
	use App\Shared\Domain\Criteria\Order;
	use App\Tests\Backoffice\District\DistrictModuleUnitTestCase;
	
	final class DistrictByCriteriaSearcherTest  extends DistrictModuleUnitTestCase
	{
		private DistrictsByCriteriaSearcher $DistrictsByCriteriaSearcher;
		
		/** @test */
		public function it_should_search_district_by_a_criteria()
		{
			$filters = Filters::fromValues([]);
			
			$order = Order::fromValues('createAt', 'desc');
			
			$criteria = new Criteria($filters, $order, null, null);
			
			$this->repository()->shouldReceive('matching')->once()->with($this->similarTo($criteria));
			
			$this->DistrictsByCriteriaSearcher = new DistrictsByCriteriaSearcher($this->repository);
			
			$this->DistrictsByCriteriaSearcher->__invoke([],'createAt','desc',null,null);

		}
		

	}