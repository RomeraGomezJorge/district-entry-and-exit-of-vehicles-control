<?php
	
	namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Infrastructure\UserInterface\Web;
	
	use App\Shared\Infrastructure\OffsetPaginationUtil;
	use App\Shared\Infrastructure\Symfony\WebController;
	use App\Shared\Infrastructure\TotalNumberOfPagesUtil;
	use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Counter\DistrictEntryAndExitOfVehiclesControlCounter;
	use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\FindByCriteriaSearcher\DistrictEntryAndExitOfVehiclesControlsByCriteriaSearcher;
	use App\Shared\Infrastructure\UserInterface\Web\TwigTemplateGlobalConstants;
	use App\Shared\Infrastructure\Utils\FilterUtils;
	use App\Shared\Infrastructure\Utils\NextPage;
	use App\Shared\Infrastructure\Utils\PreviousPage;
	use App\Shared\Infrastructure\Utils\SortUtils;
	use Dompdf\Dompdf;
	use Dompdf\Options;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	
	class DistrictEntryAndExitOfVehiclesControlGetController extends WebController
	{
		public function __invoke(
			Request $request,
			DistrictEntryAndExitOfVehiclesControlsByCriteriaSearcher $itemsByCriteriaSearcher,
			DistrictEntryAndExitOfVehiclesControlCounter $counter
		): Response {
			$orderBy = $request->get('orderBy');
			
			$order = $request->get('order');
			
			$page = $request->get('page');
			
			$limit = $request->get('limit');
			
			$filters = $filters = FilterUtils::createAnArrayToUseAsAFilter($request->get('filters'));
			
			$districtEntryAndExitOfVehiclesControl = $itemsByCriteriaSearcher->__invoke($filters,
				$order,
				$orderBy,
				$limit,
				OffsetPaginationUtil::calculate($limit, $page));
			
			$totalItem = $counter->__invoke($filters,
				$order,
				$orderBy,
				$limit,
				OffsetPaginationUtil::calculate($limit, $page));
			
			$totalNumberOfPages = TotalNumberOfPagesUtil::calculate($page, $limit, $totalItem);
			
			$html = $this->render(TwigTemplateConstants::LIST_FILE_PATH,
				[
					'page_title' => TwigTemplateConstants::SECTION_TITLE,
					'list_path' => TwigTemplateConstants::LIST_PATH,
					'edit_path' => TwigTemplateConstants::EDIT_PATH,
					'add_path' => TwigTemplateConstants::ADD_PATH,
					'delete_path' => TwigTemplateConstants::DELETE_PATH,
					'export_to_pdf_path' => TwigTemplateConstants::EXPORT_TO_PDF,
					'delete_confirmation_modal_path' => TwigTemplateGlobalConstants::DELETE_CONFIRMATION_MODAL_PATH,
					'orderBy' => $orderBy,
					'order' => $order,
					'limit' => $limit,
					'filters' => $request->get('filters'),
					'toggleSort' => SortUtils::toggle($orderBy),
					'currentPage' => $page,
					'nextPage' => NextPage::calculate($page, $totalNumberOfPages),
					'previousPage' => PreviousPage::calculate($page),
					'totalPage' => $totalNumberOfPages,
					'totalItem' => $totalItem,
					'district_entry_and_exit_of_vehicles_control' => $districtEntryAndExitOfVehiclesControl
				]);

			
			return $html;
		}
	}
	