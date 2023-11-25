<?php

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Infrastructure\UserInterface\Web;

use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Counter\DistrictEntryAndExitOfVehiclesControlCounter;
use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\FindByCriteriaSearcher\DistrictEntryAndExitOfVehiclesControlsByCriteriaSearcher;
use App\Shared\Infrastructure\OffsetPaginationUtil;
use App\Shared\Infrastructure\Symfony\WebController;
use App\Shared\Infrastructure\Utils\FilterUtils;
use Mpdf\Mpdf;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DistrictEntryAndExitOfVehiclesControlExportToPdfController extends WebController
{
    public function __invoke(
        Request                                                  $request,
        DistrictEntryAndExitOfVehiclesControlsByCriteriaSearcher $itemsByCriteriaSearcher,
        DistrictEntryAndExitOfVehiclesControlCounter             $counter
    ): Response
    {
        $orderBy = $request->get('orderBy');

        $order = $request->get('order');

        $page = $request->get('page');

        $limit = $request->get('limit');

        $filters = $filters = FilterUtils::createAnArrayToUseAsAFilter($request->get('filters'));

        $districtEntryAndExitOfVehiclesControl = $itemsByCriteriaSearcher->__invoke(
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


        setLocale(LC_ALL, "es_ES@euro", "es_ES", "esp");
        $currentDate = strftime("%A %d de %B del %Y");

        $html = $this->renderView(
            TwigTemplateConstants::EXPORT_TO_PDF_PATH,
            [
                'currentDate'                           => $currentDate,
                'totalItem'                             => $totalItem,
                'districtEntryAndExitOfVehiclesControl' => $districtEntryAndExitOfVehiclesControl
            ]
        );


        $mpdf = new mPDF(
            [
                'mode'        => 'utf-8',
                'format'      => 'Legal',
                'orientation' => 'landscape'
            ]
        );


        $mpdf->WriteHTML($html);

        $mpdf->Output('Listados de Controles Registrados en el ' . $currentDate . '.pdf', 'D');

        die();
    }
}
