<?php

namespace App\Backoffice\ModelOfVehicle\Infrastructure\UserInterface\Web;

use App\Backoffice\ModelOfVehicle\Application\Counter\ModelOfVehicleCounter;
use App\Backoffice\ModelOfVehicle\Application\FindByCriteriaSearcher\ModelsOfVehicleByCriteriaSearcher;
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

class ModelOfVehicleGetController extends WebController
{
    private const DISPLAY_ALL_VEHICLE_MAKER_NAME = [];
    private const SORT_A_LIST_BY_DESCRIPTION = 'description';
    private const SORT_A_LIST_ALPHABETICALLY = 'desc';
    private const LIST_BEGIN_ON_0 = 0;
    private const LIST_END_ON_1000 = 1000;

    public function __invoke(
        Request $request,
        ModelsOfVehicleByCriteriaSearcher $itemsByCriteriaSearcher,
        ModelOfVehicleCounter $counter,
        VehicleMakersNameByCriteriaSearcher $vehicleMakersNameByCriteriaSearcher
    ): Response {
        $orderBy           = $request->get('orderBy');
        $order             = $request->get('order');
        $page              = $request->get('page');
        $limit             = $request->get('limit');
        $filters           = FilterUtils::createAnArrayToUseAsAFilter($request->get('filters'));
        $vehicleMakersName = $this->getVehicleMarkersNameSortAlphabetically($vehicleMakersNameByCriteriaSearcher);

        $modelsOfVehicle = $itemsByCriteriaSearcher->__invoke(
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
                'models_of_vehicle'              => $modelsOfVehicle,
                'vehicle_makers_name'            => $vehicleMakersName
            ]
        );
    }

    /* Se utiliza ese metodo y no un searchAll() para poder organizar alfabeticamente
        mejorando la experiencia del usuario a la hora de buscar.
     */
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
}
