<?php
	
	declare(strict_types=1);
	
	namespace App\Tests\Backoffice\TrafficPoliceBooth\Application\FindByCriteriaSearcher;
	
	use App\Backoffice\TrafficPoliceBooth\Application\FindByCriteriaSearcher\TrafficPoliceBoothsByCriteriaSearcher;
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\Criteria\Filters;
	use App\Shared\Domain\Criteria\Order;
	use App\Tests\Backoffice\TrafficPoliceBooth\TrafficPoliceBoothModuleUnitTestCase;
	
	final class TrafficPoliceBoothByCriteriaSearcherTest extends TrafficPoliceBoothModuleUnitTestCase
	{
		private TrafficPoliceBoothsByCriteriaSearcher $trafficPoliceBoothsByCriteriaSearcher;
		
		/** @test */
		public function it_should_search_traffice_police_booth_by_a_criteria()
		{
			$filters = Filters::fromValues([]);
			
			$order = Order::fromValues('createAt', 'desc');
			
			$criteria = new Criteria($filters, $order, null, null);
			
			$this->repository()->shouldReceive('matching')->once()->with($this->similarTo($criteria));
			
			$this->trafficPoliceBoothsByCriteriaSearcher = new TrafficPoliceBoothsByCriteriaSearcher($this->repository);
			
			$this->trafficPoliceBoothsByCriteriaSearcher->__invoke([], 'createAt', 'desc', null, null);
		}
	}