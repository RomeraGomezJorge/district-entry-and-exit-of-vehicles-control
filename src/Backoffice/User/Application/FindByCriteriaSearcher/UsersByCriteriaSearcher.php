<?php
	
	declare(strict_types=1);
	
	namespace App\Backoffice\User\Application\FindByCriteriaSearcher;
	
	use App\Backoffice\Role\Application\Find\RoleFinder;
	use App\Backoffice\Role\Domain\Role;
	use App\Backoffice\Role\Domain\RoleRepository;
	use App\Backoffice\User\Domain\UserRepository;
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\Criteria\Filters;
	use App\Shared\Domain\Criteria\Order;
	use App\Shared\Infrastructure\Utils\FilterUtilsForFieldThatNotBelongToAnEntity;
	
	final class UsersByCriteriaSearcher
	{
		private UserRepository $repository;
		private RoleFinder $roleFinder;
		const FIELD_NAME_TO_ROLE = 'role';
		
		public function __construct(UserRepository $repository, RoleRepository $roleRepository)
		{
			$this->repository = $repository;
			
			$this->roleFinder = new RoleFinder($roleRepository);
		}
		
		public function __invoke($filters, $order, $orderBy, ?int $limit, ?int $offset): array
		{
			$role = $this->getRoleFromFilterOrNull($filters);
			
			$filters = $this->removeFiltersThatNotBelongToPostEntity($filters);
			
			$filters = Filters::fromValues($filters);
			
			$order = Order::fromValues($order, $orderBy);
			
			$criteria = new Criteria($filters, $order, $offset, $limit);
			
			return $this->repository->matching($criteria,$role);
		}
		
		private function getRoleFromFilterOrNull(array $filters): ?Role
		{
			if (!FilterUtilsForFieldThatNotBelongToAnEntity::isDefineAsFilter($filters,self::FIELD_NAME_TO_ROLE)) {
				return null;
			};
			
			$roleId = FilterUtilsForFieldThatNotBelongToAnEntity::getValueFromFilters($filters,
				self::FIELD_NAME_TO_ROLE);
			
			return $this->roleFinder->__invoke($roleId);
		}
		
		private function removeFiltersThatNotBelongToPostEntity($filters): array
		{
			return FilterUtilsForFieldThatNotBelongToAnEntity::removeFilter($filters,self::FIELD_NAME_TO_ROLE);
		}

	}