<?php
	
	namespace App\Backoffice\IdentityCardType\Infrastructure\UserInterface\Web;
	
	final class TwigTemplateConstants
	{
		const LIST_PATH = 'identity_card_type_list';
		const EDIT_PATH = 'identity_card_type_edit';
		const ADD_PATH = 'identity_card_type_add';
		const CREATE_PATH = 'identity_card_type_create';
		const UPDATE_PATH = 'identity_card_type_update';
		const DELETE_PATH = 'identity_card_type_delete';
		const DESCRIPTION_AVAILABLE_PATH = 'identity_card_type_description_available';
		const SECTION_TITLE = 'Tipo de documento';
		const FORM_FILE_PATH = 'backoffice/identityCardType/formToHandleItem.html.twig';
		const LIST_FILE_PATH = 'backoffice/identityCardType/list.html.twig';
	}