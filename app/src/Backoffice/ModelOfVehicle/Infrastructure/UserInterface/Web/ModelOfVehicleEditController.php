<?php

namespace App\Backoffice\ModelOfVehicle\Infrastructure\UserInterface\Web;

use App\Backoffice\ModelOfVehicle\Application\Find\ModelOfVehicleFinder;
use App\Shared\Infrastructure\Constant\FormConstant;
use App\Shared\Infrastructure\RelatedEntities;
use App\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ModelOfVehicleEditController extends WebController
{
    public function __invoke(
        Request              $request,
        ModelOfVehicleFinder $finder,
        RelatedEntities      $relatedEntities
    ): Response
    {
        $modelOfVehicle = $finder->__invoke($request->get('id'));

        return $this->render(TwigTemplateConstants::FORM_FILE_PATH, [
            'page_title'                 => TwigTemplateConstants::SECTION_TITLE,
            'list_path'                  => TwigTemplateConstants::LIST_PATH,
            'id'                         => $modelOfVehicle->getId(),
            'description'                => $modelOfVehicle->getDescription(),
            'vehicle_maker_name_id'      => $modelOfVehicle->geTVehicleMakerName()->getId(),
            'vehicle_makers_name'        => $relatedEntities->getAllVehicleMarkersNameSortAlphabetically(),
            'vehicle_body_type_id'       => $modelOfVehicle->getVehicleBodyType()->getId(),
            'vehicle_body_types'         => $relatedEntities->getAllVehicleBodyTypesSortAlphabetically(),
            'description_available_path' => TwigTemplateConstants::DESCRIPTION_AVAILABLE_PATH,
            'form_action_attribute'      => TwigTemplateConstants::UPDATE_PATH,
            'submit_button_label'        => FormConstant::SUBMIT_BUTTON_VALUE_TO_UPDATE,
            'action_to_do'               => FormConstant::UPDATE_LABEL_TEXT
        ]);
    }
}
