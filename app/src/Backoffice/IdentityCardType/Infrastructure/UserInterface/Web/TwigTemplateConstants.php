<?php

namespace App\Backoffice\IdentityCardType\Infrastructure\UserInterface\Web;

final class TwigTemplateConstants
{
    public const LIST_PATH = 'identity_card_type_list';
    public const EDIT_PATH = 'identity_card_type_edit';
    public const ADD_PATH = 'identity_card_type_add';
    public const CREATE_PATH = 'identity_card_type_create';
    public const UPDATE_PATH = 'identity_card_type_update';
    public const DELETE_PATH = 'identity_card_type_delete';
    public const DESCRIPTION_AVAILABLE_PATH = 'identity_card_type_description_available';
    public const SECTION_TITLE = 'Tipo de documento';
    public const FORM_FILE_PATH = 'backoffice/identityCardType/formToHandleItem.html.twig';
    public const LIST_FILE_PATH = 'backoffice/identityCardType/list.html.twig';
}
