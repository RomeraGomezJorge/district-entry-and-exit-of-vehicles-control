<?php
	
	
	namespace App\Backoffice\IdentityCardType\Infrastructure\Persistence;
	
	
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\ValueObject\Uuid;
	use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
	use App\Backoffice\IdentityCardType\Domain\IdentityCardType;
	use App\Backoffice\IdentityCardType\Domain\IdentityCardTypeRepository;
	use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
	use Doctrine\Common\Collections\Collection;
	
	final class MySqlIdentityCardTypeRepository extends DoctrineRepository implements IdentityCardTypeRepository
	{
		const NOT_SETTING_VALUE = null;
		const ENTITY_CLASS = IdentityCardType::class;
		private ?int $totalMatchingRows = null;
		
		public function save(IdentityCardType $identityCardType): void
		{
			$this->persist($identityCardType);
		}
		
		public function search(Uuid $id): ?IdentityCardType
		{
			return $this->repository(self::ENTITY_CLASS)->find($id);
		}
		
		public function searchAll(): array
		{
			return $this->repository(self::ENTITY_CLASS)->findAll();
		}
		
		public function isDescriptionExits(array $criteria): bool
		{
			$isUnique = (bool)$this->repository(self::ENTITY_CLASS)->findOneBy($criteria);
			
			return $isUnique;
		}
		
		public function matching(Criteria $criteria): array
		{
			$matching = $this->getMatchingFrom($criteria);
			
			$this->totalMatchingRows = $matching->count();
			
			return $matching->toArray();
		}
		
		public function totalMatchingRows(Criteria $criteria): int
		{
			if ($this->totalMatchingRows === self::NOT_SETTING_VALUE) {
				return $this->getMatchingFrom($criteria)->count();
			}
			
			return $this->totalMatchingRows;
		}
		
		public function delete(IdentityCardType $identityCardType): void
		{
			$this->remove($identityCardType);
		}
		
		private function getMatchingFrom(Criteria $criteria): Collection
		{
			$doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
			
			return $this->repository(self::ENTITY_CLASS)->matching($doctrineCriteria);
		}
	}