<?php
	
	namespace App\Tests\Backoffice\User\Application\FindByCriteriaSearcher;
	
	use App\Backoffice\Role\Domain\Exception\RoleNotExist;
	use App\Backoffice\Role\Domain\Role;
	use App\Backoffice\User\Application\FindByCriteriaSearcher\UsersByCriteriaSearcher;
	use App\Backoffice\User\Application\Shared\FilterUtilsForUser;
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\Criteria\Filters;
	use App\Shared\Domain\Criteria\Order;
	use App\Tests\Backoffice\User\Domain\UserMother;
	use App\Tests\Backoffice\User\UserModuleUnitTestCase;
	
	final class UsersByCriteriaSearcherTest  extends UserModuleUnitTestCase
	{
		private const ROLE_HAS_NOT_BEEN_DEFINED_AS_FILTER = null;
		private const LIMIT_HAS_NOT_BEEN_DEFINED_AS_FILTER = null;
		private const OFFSET_HAS_NOT_BEEN_DEFINED_AS_FILTER = null;
		private const EMPTY_FILTER = [];
		private  $usersByCriteriaSearcher;
		private Role $role;
		
		protected function setUp(): void
		{
			$this->usersByCriteriaSearcher = new UsersByCriteriaSearcher(
				$this->repository(),
				new FilterUtilsForUser($this->roleRepository())
			);
			
			$this->role = UserMother::createRandomRole();
		}
		
		/** @test */
		public function it_should_search_all_user()
		{
			$criteria = $this->createCriteria(self::EMPTY_FILTER);
			
			$this->repository()
				->shouldReceive('matching')
				->once()
				->with(
					$this->similarTo($criteria),
					self::ROLE_HAS_NOT_BEEN_DEFINED_AS_FILTER
				);
			
			$this->usersByCriteriaSearcher->__invoke(
				self::EMPTY_FILTER,
				'createAt',
				'desc',
				self::LIMIT_HAS_NOT_BEEN_DEFINED_AS_FILTER,
				self::OFFSET_HAS_NOT_BEEN_DEFINED_AS_FILTER);
		}
		
		/** @test */
		public function it_should_search_user_with_roleId_criteria()
		{
			$shouldRemoveRoleIdAsFilterBecauseDontBelongToPostEntity = self::EMPTY_FILTER;
			
			$criteria = $this->createCriteria($shouldRemoveRoleIdAsFilterBecauseDontBelongToPostEntity);
			
			$this->shouldFindARole($this->role->getId(), $this->role);
			
			$this->repository()->shouldReceive('matching')->once()->with(
				$this->similarTo($criteria),
				$this->similarTo($this->role)
			);
			
			$this->usersByCriteriaSearcher->__invoke(
				$this->roleFilterEqualsTo($this->role->getId()),
				'createAt',
				'desc',
				self::LIMIT_HAS_NOT_BEEN_DEFINED_AS_FILTER,
				self::OFFSET_HAS_NOT_BEEN_DEFINED_AS_FILTER);
		}
		
		/** @test */
		public function it_should_throw_an_exception_when_role_does_not_exist(): void
		{
			$this->expectException(RoleNotExist::class);
			
			$this->shouldNotFindARole($this->role->getId());
			
			$this->repository()->shouldReceive('matching')->never();
			
			$this->usersByCriteriaSearcher->__invoke(
				$this->roleFilterEqualsTo($this->role->getId()),
				'createAt',
				'desc',
				self::LIMIT_HAS_NOT_BEEN_DEFINED_AS_FILTER,
				self::OFFSET_HAS_NOT_BEEN_DEFINED_AS_FILTER);
		}
		
		private function createCriteria(array $filter): Criteria
		{
			$filters = Filters::fromValues($filter);
			
			$order = Order::fromValues('createAt', 'desc');
			
			return new Criteria($filters, $order, self::OFFSET_HAS_NOT_BEEN_DEFINED_AS_FILTER, self::LIMIT_HAS_NOT_BEEN_DEFINED_AS_FILTER);
			
		}
		
		private function roleFilterEqualsTo($value): array
		{
			$filter[0]['field'] = 'role';
			$filter[0]['operator'] = '=';
			$filter[0]['value'] = $value;
			return $filter;
		}
	}