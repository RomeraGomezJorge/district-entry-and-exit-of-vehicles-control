<?php
	
	namespace App\Backoffice\User\Infrastructure\Persistence;
	
	use App\Backoffice\Role\Domain\Role;
	use App\Backoffice\User\Domain\User;
	use App\Backoffice\User\Domain\UserRepository;
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
	use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
	use Doctrine\Common\Collections\Criteria as DoctrineCriteria;
	
	final class MySqlUserRepository extends DoctrineRepository implements UserRepository
	{
		public function save(User $user): void
		{
			$this->persist($user);
		}
		
		public function search(Uuid $id): ?User
		{
			return $this->repository(User::class)->find($id);
		}
		
		public function searchByEmail(string $email): ?User
		{
			return $this->repository(User::class)->findOneBy(['email' => $email]);
		}
		
		public function searchAll(): array
		{
			return $this->repository(User::class)->findAll();
		}
		
		public function isUserNameExits(array $criteria): bool
		{
			$isUnique = (bool)$this->repository(User::class)->findOneBy($criteria);
			
			return $isUnique;
		}
		
		public function isEmailExits(array $criteria): bool
		{
			$isUnique = (bool)$this->repository(User::class)->findOneBy($criteria);
			
			return $isUnique;
		}
		
		public function matching(Criteria $criteria, ?Role $role): array
		{
			$doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
			
			$doctrineCriteria = $this->isNotNullAddAsFilter($role,$doctrineCriteria);
			
			return $this->repository(User::class)->matching($doctrineCriteria)->toArray();
		}
		
		
		public function totalMatchingRows(Criteria $criteria, ?Role $role): int
		{
			$doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
			
			$doctrineCriteria = $this->isNotNullAddAsFilter($role,$doctrineCriteria);
			
			return $this->repository(User::class)->matching($doctrineCriteria)->count();
		}
		
		public function delete(User $user): void
		{
			$this->remove($user);
		}
		
		private function isNotNullAddAsFilter(
			?Role $role,
			DoctrineCriteria $doctrineCriteria
		): DoctrineCriteria {
			
			if (is_null($role)) {
				return $doctrineCriteria;
			}
			
			return $doctrineCriteria->andWhere(
				DoctrineCriteria::expr()->eq(
					'role',
					$role
				)
			);
		}
	}