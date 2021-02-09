<?php
	
	namespace App\Backoffice\IdentityCardType\Application\Update;
	
	use App\Backoffice\IdentityCardType\Application\Find\IdentityCardTypeFinder;
	use App\Backoffice\IdentityCardType\Domain\IdentityCardType;
	use App\Backoffice\IdentityCardType\Domain\IdentityCardTypeRepository;
	use App\Backoffice\IdentityCardType\Domain\UniqueIdentityCardTypeDescriptionSpecification;
	
	final class IdentityCardTypeUpdater
	{
		private IdentityCardTypeRepository $repository;
		
		private IdentityCardTypeFinder  $finder;
		
		private UniqueIdentityCardTypeDescriptionSpecification $uniqueIdentityCardTypeDescriptionSpecification;
		
		public function __construct(
			IdentityCardTypeRepository $repository,
			UniqueIdentityCardTypeDescriptionSpecification $uniqueIdentityCardTypeDescriptionSpecification
		) {
			$this->repository = $repository;
			$this->finder = new IdentityCardTypeFinder($repository);
			$this->uniqueIdentityCardTypeDescriptionSpecification = $uniqueIdentityCardTypeDescriptionSpecification;
		}
		
		public function __invoke(string $id, string $newDescription): void
		{
			$identityCardType = $this->finder->__invoke($id);
			
			if ($this->hasDescriptionChanged($newDescription, $identityCardType)) {
				$identityCardType->setDescription($newDescription, $this->uniqueIdentityCardTypeDescriptionSpecification);
			}
			
			$this->repository->save($identityCardType);
		}
		
		
		private function hasDescriptionChanged(string $newDescription, IdentityCardType $identityCardType): bool
		{
			return strcmp($newDescription, $identityCardType->getDescription()) !== 0 ? true : false;
		}
	}