<?php
	
	
	namespace App\Backoffice\District\Infrastructure\Persistence;
	
	
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
	use App\Backoffice\District\Domain\District;
	use App\Backoffice\District\Domain\DistrictRepository;
	use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
	
	final class MySqlDistrictRepository extends DoctrineRepository implements DistrictRepository
	{
		public function save(District $district): void
		{
			$this->persist($district);
		}
		
		public function search(Uuid $id): ?District
		{
			return $this->repository(District::class)->find($id);
		}
		
		public function searchAll(): array
		{
			return $this->repository(District::class)->findAll();
		}
		
		public function isDescriptionExits(array $criteria): bool
		{
			$isUnique = (bool)$this->repository(District::class)->findOneBy($criteria);
			
			return $isUnique;
		}
		
		public function matching(Criteria $criteria): array
		{
			$doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
			
			return $this->repository(District::class)->matching($doctrineCriteria)->toArray();
		}
		
		public function totalMatchingRows(Criteria $criteria): int
		{
			$doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
			
			return $this->repository(District::class)->matching($doctrineCriteria)->count();
		}
		
		public function delete(District $district): void
		{
			$this->remove($district);
		}
	}