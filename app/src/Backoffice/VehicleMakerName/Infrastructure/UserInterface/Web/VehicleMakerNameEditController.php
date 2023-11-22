<?php

namespace App\Backoffice\VehicleMakerName\Infrastructure\UserInterface\Web;

use App\Backoffice\VehicleMakerName\Application\Find\VehicleMakerNameFinder;
use App\Shared\Infrastructure\Constant\FormConstant;
use App\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VehicleMakerNameEditController extends WebController
{
    public function __invoke(Request $request, VehicleMakerNameFinder $finder): Response
    {
        $vehicleMakerName = $finder->__invoke($request->get('id'));

        return $this->render(TwigTemplateConstants::FORM_FILE_PATH, [
            'page_title'                 => TwigTemplateConstants::SECTION_TITLE,
            'list_path'                  => TwigTemplateConstants::LIST_PATH,
            'id'                         => $vehicleMakerName->getId(),
            'description'                => $vehicleMakerName->getDescription(),
            'description_available_path' => TwigTemplateConstants::DESCRIPTION_AVAILABLE_PATH,
            'form_action_attribute'      => TwigTemplateConstants::UPDATE_PATH,
            'submit_button_label'        => FormConstant::SUBMIT_BUTTON_VALUE_TO_UPDATE,
            'action_to_do'               => FormConstant::UPDATE_LABEL_TEXT,
        ]);
    }
}
