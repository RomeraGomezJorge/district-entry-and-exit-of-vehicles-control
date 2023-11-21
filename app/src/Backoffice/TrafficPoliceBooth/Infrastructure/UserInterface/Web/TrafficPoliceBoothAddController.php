<?php
	
	
	namespace App\Backoffice\TrafficPoliceBooth\Infrastructure\UserInterface\Web;

	
	use App\Shared\Infrastructure\Constant\FormConstant;
	use App\Shared\Infrastructure\RamseyUuidGenerator;
	use App\Shared\Infrastructure\Symfony\FlashSession;
	use App\Shared\Infrastructure\Symfony\WebController;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	
	class TrafficPoliceBoothAddController  extends  WebController
	{
		public function __invoke(FlashSession $flashSession,RamseyUuidGenerator $ramseyUuidGenerator ): Response
		{
			return $this->render(TwigTemplateConstants::FORM_FILE_PATH, [
				'list_path' => TwigTemplateConstants::LIST_PATH,
				'page_title' => TwigTemplateConstants::SECTION_TITLE,
				'id' => $ramseyUuidGenerator->generate(),
				'description_available_path' => TwigTemplateConstants::DESCRIPTION_AVAILABLE_PATH,
				'description' => $flashSession->get('inputs.description'),
				'form_action_attribute' => TwigTemplateConstants::CREATE_PATH,
				'submit_button_label' => FormConstant::SUBMIT_BUTTON_VALUE_TO_CREATE,
				'action_to_do' => FormConstant::CREATE_LABEL_TEXT,
			]);
		}
	}