<?php

namespace App\Backoffice\VehicleMakerName\Infrastructure\UserInterface\Web;

use App\Backoffice\VehicleMakerName\Application\Counter\VehicleMakerNameCounter;
use App\Backoffice\VehicleMakerName\Application\FindByCriteriaSearcher\VehicleMakersNameByCriteriaSearcher;
use App\Shared\Infrastructure\OffsetPaginationUtil;
use App\Shared\Infrastructure\Symfony\WebController;
use App\Shared\Infrastructure\TotalNumberOfPagesUtil;
use App\Shared\Infrastructure\UserInterface\Web\TwigTemplateGlobalConstants;
use App\Shared\Infrastructure\Utils\FilterUtils;
use App\Shared\Infrastructure\Utils\NextPage;
use App\Shared\Infrastructure\Utils\PreviousPage;
use App\Shared\Infrastructure\Utils\SortUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VehicleMakerNameGetController extends WebController
{
    public function __invoke(
        Request $request,
        VehicleMakersNameByCriteriaSearcher $itemsByCriteriaSearcher,
        VehicleMakerNameCounter $counter
    ): Response {
        $orderBy = $request->get('orderBy');

        $order = $request->get('order');

        $page = $request->get('page');

        $limit = $request->get('limit');

        $filters = FilterUtils::createAnArrayToUseAsAFilter($request->get('filters'));

        $vehicleMakerName = $itemsByCriteriaSearcher->__invoke(
            $filters,
            $order,
            $orderBy,
            $limit,
            OffsetPaginationUtil::calculate($limit, $page)
        );

        $totalItem = $counter->__invoke(
            $filters,
            $order,
            $orderBy,
            $limit,
            OffsetPaginationUtil::calculate($limit, $page)
        );

        $totalNumberOfPages = TotalNumberOfPagesUtil::calculate($page, $limit, $totalItem);

        return $this->render(
            TwigTemplateConstants::LIST_FILE_PATH,
            [
                'page_title'                     => TwigTemplateConstants::SECTION_TITLE,
                'list_path'                      => TwigTemplateConstants::LIST_PATH,
                'edit_path'                      => TwigTemplateConstants::EDIT_PATH,
                'add_path'                       => TwigTemplateConstants::ADD_PATH,
                'delete_path'                    => TwigTemplateConstants::DELETE_PATH,
                'delete_confirmation_modal_path' => TwigTemplateGlobalConstants::DELETE_CONFIRMATION_MODAL_PATH,
                'orderBy'                        => $orderBy,
                'order'                          => $order,
                'limit'                          => $limit,
                'filters'                        => $request->get('filters'),
                'toggleSort'                     => SortUtils::toggle($orderBy),
                'currentPage'                    => $page,
                'nextPage'                       => NextPage::calculate($page, $totalNumberOfPages),
                'previousPage'                   => PreviousPage::calculate($page),
                'totalPage'                      => $totalNumberOfPages,
                'totalItem'                      => $totalItem,
                'vehicle_makers_name'            => $vehicleMakerName
            ]
        );
    }
}
