<?php

namespace App\Backoffice\ModelOfVehicle\Infrastructure\UserInterface\Web;

use App\Shared\Infrastructure\Constant\FormConstant;
use App\Shared\Infrastructure\RamseyUuidGenerator;
use App\Shared\Infrastructure\RelatedEntities;
use App\Shared\Infrastructure\Symfony\FlashSession;
use App\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Response;

class ModelOfVehicleAddController extends WebController
{
    public function __invoke(
        FlashSession        $flashSession,
        RamseyUuidGenerator $ramseyUuidGenerator,
        RelatedEntities     $relatedEntities
    ): Response
    {
        return $this->render(TwigTemplateConstants::FORM_FILE_PATH, [
            'list_path'                  => TwigTemplateConstants::LIST_PATH,
            'page_title'                 => TwigTemplateConstants::SECTION_TITLE,
            'id'                         => $ramseyUuidGenerator->generate(),
            'description_available_path' => TwigTemplateConstants::DESCRIPTION_AVAILABLE_PATH,
            'description'                => $flashSession->get('inputs.description'),
            'vehicle_makers_name'        => $relatedEntities->getAllVehicleMarkersNameSortAlphabetically(),
            'vehicleMakerNameId'         => $flashSession->get('inputs.vehicleMakerNameId'),
            'vehicleBodyTypeId'          => $flashSession->get('inputs.vehicleBodyTypeId'),
            'vehicle_body_types'         => $relatedEntities->getAllVehicleBodyTypesSortAlphabetically(),
            'form_action_attribute'      => TwigTemplateConstants::CREATE_PATH,
            'submit_button_label'        => FormConstant::SUBMIT_BUTTON_VALUE_TO_CREATE,
            'action_to_do'               => FormConstant::CREATE_LABEL_TEXT,
        ]);
    }
}
