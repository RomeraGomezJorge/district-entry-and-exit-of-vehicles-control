<?php
	
	
	namespace App\Backoffice\User\Infrastructure\UserInterface\Web;
	
	use App\Backoffice\Role\Domain\RoleRepository;
	use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBooth;
	use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBoothRepository;
	use App\Shared\Infrastructure\Constant\FormConstant;
	use App\Shared\Infrastructure\RamseyUuidGenerator;
	use App\Shared\Infrastructure\Symfony\FlashSession;
	use App\Shared\Infrastructure\Symfony\WebController;
	use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
	use Symfony\Component\HttpFoundation\Session\Session;
	use Symfony\Component\HttpFoundation\Response;
	
	class UserAddController extends WebController
	{
		public function __invoke(
			FlashSession $flashSession,
			RamseyUuidGenerator $ramseyUuidGenerator,
			RoleRepository $roleRepository,
			TrafficPoliceBoothRepository $trafficPoliceBoothRepository
		): Response {
			return $this->render(TwigTemplateConstants::FORM_FILE_PATH, [
				'list_path' => TwigTemplateConstants::LIST_PATH,
				'page_title' => TwigTemplateConstants::SECTION_TITLE,
				'user_name_available_path' => TwigTemplateConstants::USER_NAME_AVAILABLE_PATH,
				'email_available_path' => TwigTemplateConstants::EMAIL_AVAILABLE_PATH,
				'id' => $ramseyUuidGenerator->generate(),
				'username' => $flashSession->get('inputs.username'),
				'name' => $flashSession->get('inputs.name'),
				'surname' => $flashSession->get('inputs.surname'),
				'email' => $flashSession->get('inputs.email'),
				'password' => '',
				'role_id' => $flashSession->get('inputs.role_id'),
				'isActive' => $flashSession->get('inputs.isActive'),
				'roles' => $roleRepository->searchAll(),
				'trafficPoliceBooth_id' => $flashSession->get('inputs.trafficPoliceBooth_id'),
				'trafficPoliceBooths' => $trafficPoliceBoothRepository->searchAll(),
				'form_action_attribute' => TwigTemplateConstants::CREATE_PATH,
				'submit_bButton_label' => FormConstant::SUBMIT_BUTTON_VALUE_TO_CREATE,
				'action_to_do' => FormConstant::CREATE_LABEL_TEXT,
			]);
		}
	}
