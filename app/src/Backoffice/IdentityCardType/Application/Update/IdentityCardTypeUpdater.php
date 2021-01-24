<?php
	
	namespace App\Backoffice\IdentityCardType\Application\Update;
	
	use App\Backoffice\IdentityCardType\Application\Find\IdentityCardTypeFinder;
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
			
			$identityCardType->changeDescription(trim($newDescription),
				$this->uniqueIdentityCardTypeDescriptionSpecification);
			
			$this->repository->save($identityCardType);
		}
	}