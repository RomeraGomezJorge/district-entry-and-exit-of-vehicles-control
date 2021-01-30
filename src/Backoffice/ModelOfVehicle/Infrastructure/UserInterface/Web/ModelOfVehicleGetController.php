<?php
	
	namespace App\Backoffice\ModelOfVehicle\Infrastructure\UserInterface\Web;
	
	use App\Backoffice\VehicleMakerName\Application\FindByCriteriaSearcher\VehicleMakersNameByCriteriaSearcher;
	use App\Shared\Infrastructure\OffsetPaginationUtil;
	use App\Shared\Infrastructure\Symfony\WebController;
	use App\Shared\Infrastructure\TotalNumberOfPagesUtil;
	use App\Backoffice\ModelOfVehicle\Application\Counter\ModelOfVehicleCounter;
	use App\Backoffice\ModelOfVehicle\Application\FindByCriteriaSearcher\ModelsOfVehicleByCriteriaSearcher;
	use App\Shared\Infrastructure\UserInterface\Web\TwigTemplateGlobalConstants;
	use App\Shared\Infrastructure\Utils\NextPage;
	use App\Shared\Infrastructure\Utils\PreviousPage;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	
	
	class ModelOfVehicleGetController extends WebController
	{
		const DISPLAY_ALL_VEHICLE_MAKER_NAME = [];
		const SORT_A_LIST_BY_DESCRIPTION = 'description';
		const SORT_A_LIST_ALPHABETICALLY = 'desc';
		const LIST_BEGIN_ON_0 = 0;
		const LIST_END_ON_1000 = 1000;
		
		public function __invoke(
			Request $request,
			ModelsOfVehicleByCriteriaSearcher $itemsByCriteriaSearcher,
			ModelOfVehicleCounter $counter,
			VehicleMakersNameByCriteriaSearcher $vehicleMakersNameByCriteriaSearcher
		): Response {
			$orderBy = $request->get('orderBy');
			
			$order = $request->get('order');
			
			$page = $request->get('page');
			
			$limit = $request->get('limit');
			
			$filters = $this->filters($request->get('filters'));
			
			$modelsOfVehicle = $itemsByCriteriaSearcher->__invoke(
				$filters,
				$order,
				$orderBy,
				$limit,
				OffsetPaginationUtil::calculate($limit, $page));
			
			$totalItem = 2;

//			$totalItem = $counter->__invoke(
//				$filters,
//				$order,
//				$orderBy,
//				$limit,
//				OffsetPaginationUtil::calculate($limit, $page));
			
			$totalNumberOfPages = TotalNumberOfPagesUtil::calculate($page, $limit, $totalItem);
			
			$vehicleMakersName = $this->getVehicleMarkersNameSortAlphabetically($vehicleMakersNameByCriteriaSearcher);
			
			return $this->render(TwigTemplateConstants::LIST_FILE_PATH, [
				'page_title' => TwigTemplateConstants::SECTION_TITLE,
				'list_path' => TwigTemplateConstants::LIST_PATH,
				'edit_path' => TwigTemplateConstants::EDIT_PATH,
				'add_path' => TwigTemplateConstants::ADD_PATH,
				'delete_path' => TwigTemplateConstants::DELETE_PATH,
				'delete_confirmation_modal_path' => TwigTemplateGlobalConstants::DELETE_CONFIRMATION_MODAL_PATH,
				'orderBy' => $orderBy,
				'order' => $order,
				'limit' => $limit,
				'filters' => $request->get('filters'),
				'toggleSort' => $this->toggleSort($orderBy),
				'currentPage' => $page,
				'nextPage' => NextPage::calculate($page, $totalNumberOfPages),
				'previousPage' => PreviousPage::calculate($page),
				'totalPage' => $totalNumberOfPages,
				'totalItem' => $totalItem,
				'modelsOfVehicle' => $modelsOfVehicle,
				'vehicleMakersName' => $vehicleMakersName
			]);
		}
		
		private function filters(?string $stringOfFilterArrayStruct): array
		{
			if ($stringOfFilterArrayStruct === null) {
				return array();
			}
			
			parse_str($stringOfFilterArrayStruct);
			
			if (!isset($filters)) {
				return array();
			}
			
			return $filters;
		}
		
		private function getVehicleMarkersNameSortAlphabetically(
			VehicleMakersNameByCriteriaSearcher $vehicleMakersNameByCriteriaSearcher
		): array {
			return $vehicleMakersNameByCriteriaSearcher->__invoke(
				self::DISPLAY_ALL_VEHICLE_MAKER_NAME,
				self::SORT_A_LIST_BY_DESCRIPTION,
				self::SORT_A_LIST_ALPHABETICALLY,
				self::LIST_END_ON_1000,
				self::LIST_BEGIN_ON_0
			);
		}
		
		/* Se utiliza ese metodo y no un searchAll() para poder organizar alfabeticamente
			mejorando la experiencia del usuario a la hora de buscar.
		 */
		
		private function toggleSort($sort): string
		{
			return $sort === 'asc' ? 'desc' : 'asc';
		}
	}
	