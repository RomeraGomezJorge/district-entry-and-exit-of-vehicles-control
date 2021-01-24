<?php
	
	
	namespace App\Backoffice\Role\Domain;
	
	
	use App\Shared\Domain\ValueObject\Uuid;
	
	interface RoleRepository
	{
		public function save( Role $id): void;
		
		public function search( string $id ):?Role;
		
		public function searchAll(): array;

	}