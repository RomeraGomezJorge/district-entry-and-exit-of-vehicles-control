<?php
	
	namespace App\Backoffice\User\Infrastructure\UserInterface\Web;
	
	final class TwigTemplateConstants
	{
		const LIST_PATH = 'user_list';
		const EDIT_PATH = 'user_edit';
		const ADD_PATH = 'user_add';
		const CREATE_PATH = 'user_create';
		const UPDATE_PATH = 'user_update';
		const DELETE_PATH = 'user_delete';
		const USER_NAME_AVAILABLE_PATH = 'user_name_available';
		const EMAIL_AVAILABLE_PATH = 'user_email_available';
		const DELETE_CONFIRM_MODAL_PATH = 'user_delete_confirm_modal';
		const RESET_PASSWORD_MODAL_PATH = 'user_reset_password_modal';
		const RESET_PASSWORD_PATH = 'user_reset_password';
		const SECTION_TITLE = 'Usuarios';
		const FORM_FILE_PATH = 'backoffice/user/formToHandleItem.html.twig';
		const USER_ROLES = ['ROLE_ADMIN','ROLE_USER'];
	}