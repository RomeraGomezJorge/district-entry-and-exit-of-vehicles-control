<?php

namespace App\Backoffice\ReasonForTrip\Infrastructure\UserInterface\Web;

use App\Backoffice\ReasonForTrip\Application\Find\ReasonForTripFinder;
use App\Shared\Infrastructure\Constant\FormConstant;
use App\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReasonForTripEditController extends WebController
{
    public function __invoke(Request $request, ReasonForTripFinder $finder): Response
    {
        $reasonForTrip = $finder->__invoke($request->get('id'));

        return $this->render(TwigTemplateConstants::FORM_FILE_PATH, [
            'page_title'                 => TwigTemplateConstants::SECTION_TITLE,
            'list_path'                  => TwigTemplateConstants::LIST_PATH,
            'id'                         => $reasonForTrip->getId(),
            'description'                => $reasonForTrip->getDescription(),
            'description_available_path' => TwigTemplateConstants::DESCRIPTION_AVAILABLE_PATH,
            'form_action_attribute'      => TwigTemplateConstants::UPDATE_PATH,
            'submit_button_label'        => FormConstant::SUBMIT_BUTTON_VALUE_TO_UPDATE,
            'action_to_do'               => FormConstant::UPDATE_LABEL_TEXT,
        ]);
    }
}
