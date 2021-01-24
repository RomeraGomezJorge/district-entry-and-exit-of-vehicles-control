<?php
	
	namespace App\Backoffice\TrafficPoliceBooth\Infrastructure\UserInterface\Web;
	
	final class TwigTemplateConstants
	{
		const LIST_PATH = 'traffic_police_booth_list';
		const EDIT_PATH = 'traffic_police_booth_edit';
		const ADD_PATH = 'traffic_police_booth_add';
		const CREATE_PATH = 'traffic_police_booth_create';
		const UPDATE_PATH = 'traffic_police_booth_update';
		const DELETE_PATH = 'traffic_police_booth_delete';
		const DESCRIPTION_AVAILABLE_PATH = 'traffic_police_booth_description_available';
		const SECTION_TITLE = 'Puesto de Control';
		const FORM_FILE_PATH = 'backoffice/trafficPoliceBooth/formToHandleItem.html.twig';
		const LIST_FILE_PATH = 'backoffice/trafficPoliceBooth/list.html.twig';
	}