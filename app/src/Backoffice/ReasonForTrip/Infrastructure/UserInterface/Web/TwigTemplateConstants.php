<?php

namespace App\Backoffice\ReasonForTrip\Infrastructure\UserInterface\Web;

final class TwigTemplateConstants
{
    public const LIST_PATH = 'reason_for_trip_list';
    public const EDIT_PATH = 'reason_for_trip_edit';
    public const ADD_PATH = 'reason_for_trip_add';
    public const CREATE_PATH = 'reason_for_trip_create';
    public const UPDATE_PATH = 'reason_for_trip_update';
    public const DELETE_PATH = 'reason_for_trip_delete';
    public const DESCRIPTION_AVAILABLE_PATH = 'reason_for_trip_description_available';
    public const SECTION_TITLE = 'Motivo de viaje';
    public const FORM_FILE_PATH = 'backoffice/reasonForTrip/formToHandleItem.html.twig';
    public const LIST_FILE_PATH = 'backoffice/reasonForTrip/list.html.twig';
}
