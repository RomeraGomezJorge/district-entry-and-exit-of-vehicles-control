<?php
	
	namespace App\Backoffice\ModelOfVehicle\Infrastructure\UserInterface\Web;
	
	use Symfony\Component\Validator\ConstraintViolationListInterface;
	use Symfony\Component\Validator\Validation;
	use Symfony\Component\Validator\Constraints as Assert;
	
	final class ValidationRulesToCreateAndUpdate
	{
		
		public static function verify($request): ConstraintViolationListInterface
		{
			$constraint = new Assert\Collection(
				[
					'id' => new Assert\Uuid(),
					'description' => new Assert\NotBlank(),
					'csrf_token' => new Assert\NotBlank(),
					'vehicleMakerName_id' => new Assert\Uuid(),
				]
			);
			
			$input = $request->request->all();
			
			return Validation::createValidator()->validate($input, $constraint);
		}
	}