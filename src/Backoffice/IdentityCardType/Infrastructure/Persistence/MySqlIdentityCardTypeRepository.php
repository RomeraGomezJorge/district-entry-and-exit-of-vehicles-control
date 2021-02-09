<?php
	
	
	namespace App\Backoffice\IdentityCardType\Infrastructure\Persistence;
	
	
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
	use App\Backoffice\IdentityCardType\Domain\IdentityCardType;
	use App\Backoffice\IdentityCardType\Domain\IdentityCardTypeRepository;
	use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
	
	final class MySqlIdentityCardTypeRepository extends DoctrineRepository implements IdentityCardTypeRepository
	{
		public function save(IdentityCardType $identityCardType): void
		{
			$this->persist($identityCardType);
		}
		
		public function search(Uuid $id): ?IdentityCardType
		{
			return $this->repository(IdentityCardType::class)->find($id);
		}
		
		public function searchAll(): array
		{
			return $this->repository(IdentityCardType::class)->findAll();
		}
		
		public function isDescriptionExits(array $criteria): bool
		{
			$isUnique = (bool)$this->repository(IdentityCardType::class)->findOneBy($criteria);
			
			return $isUnique;
		}
		
		public function matching(Criteria $criteria): array
		{
			$doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
			
			return $this->repository(IdentityCardType::class)->matching($doctrineCriteria)->toArray();
		}
		
		public function totalMatchingRows(Criteria $criteria): int
		{
			$doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
			
			return $this->repository(IdentityCardType::class)->matching($doctrineCriteria)->count();
		}
		
		public function delete(IdentityCardType $identityCardType): void
		{
			$this->remove($identityCardType);
		}
	}