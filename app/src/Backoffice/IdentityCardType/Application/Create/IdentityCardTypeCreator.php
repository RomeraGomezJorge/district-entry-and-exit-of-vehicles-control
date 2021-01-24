<?php
	
	namespace App\Backoffice\IdentityCardType\Application\Create;
	
	use App\Backoffice\IdentityCardType\Domain\IdentityCardType;
	use App\Shared\Domain\Bus\Event\EventBus;
	use App\Backoffice\IdentityCardType\Domain\IdentityCardTypeRepository;
	use App\Backoffice\IdentityCardType\Domain\UniqueIdentityCardTypeDescriptionSpecification;
	use App\Shared\Domain\ValueObject\Uuid;
	
	final class IdentityCardTypeCreator
	{
		private IdentityCardTypeRepository $repository;
		private UniqueIdentityCardTypeDescriptionSpecification $uniqueIdentityCardTypeDescriptionSpecification;
		private EventBus $bus;
		
		public function __construct(
			IdentityCardTypeRepository $repository,
			UniqueIdentityCardTypeDescriptionSpecification $uniqueIdentityCardTypeDescriptionSpecification,
			EventBus $bus
		) {
			$this->repository = $repository;
			$this->uniqueIdentityCardTypeDescriptionSpecification = $uniqueIdentityCardTypeDescriptionSpecification;
			$this->bus = $bus;
		}
		
		public function __invoke(string $id, string $description)
		{
			$id = new Uuid($id);
			
			$createAt = new \DateTime();
			
			$identityCardType = IdentityCardType::create(
				$id,
				trim($description),
				$createAt,
				$this->uniqueIdentityCardTypeDescriptionSpecification);
			
			$this->repository->save($identityCardType);
			
			$this->bus->publish(...$identityCardType->pullDomainEvents());
		}
	}