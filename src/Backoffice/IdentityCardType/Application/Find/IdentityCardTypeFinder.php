<?php
	
	
	namespace App\Backoffice\IdentityCardType\Application\Find;
	
	use App\Backoffice\IdentityCardType\Domain\Exception\IdentityCardTypeNotExist;
	use App\Backoffice\IdentityCardType\Domain\IdentityCardType;
	use App\Backoffice\IdentityCardType\Domain\IdentityCardTypeRepository;
	use App\Shared\Domain\ValueObject\Uuid;
	
	final class IdentityCardTypeFinder
	{
		private IdentityCardTypeRepository $repository;
		
		public function __construct(IdentityCardTypeRepository $repository)
		{
			$this->repository = $repository;
		}
		
		public function __invoke(string $id): IdentityCardType
		{
			$id = new Uuid($id);
			
			$identityCardType = $this->repository->search($id);
			
			if (null === $identityCardType) {
				throw new IdentityCardTypeNotExist($id);
			}
			
			return $identityCardType;
		}
	}