<?php

namespace App\Backoffice\User\Infrastructure\UserInterface\Web;

use App\Backoffice\Role\Domain\RoleRepository;
use App\Backoffice\User\Application\Counter\UserCounter;
use App\Backoffice\User\Application\FindByCriteriaSearcher\UsersByCriteriaSearcher;
use App\Shared\Infrastructure\OffsetPaginationUtil;
use App\Shared\Infrastructure\Symfony\WebController;
use App\Shared\Infrastructure\TotalNumberOfPagesUtil;
use App\Shared\Infrastructure\UserInterface\Web\TwigTemplateGlobalConstants;
use App\Shared\Infrastructure\Utils\NextPage;
use App\Shared\Infrastructure\Utils\PreviousPage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class UserGetController extends WebController
{
    public function __invoke(Request $request,UsersByCriteriaSearcher $itemsByCriteriaSearcher, UserCounter $counter, RoleRepository $roleRepository): Response
    {
        $orderBy = $request->get('orderBy');

        $order = $request->get('order');

        $page = $request->get('page');

        $limit = $request->get('limit');

        $filters = $this->filters($request->get('filters'));

        $users = $itemsByCriteriaSearcher->__invoke($filters, $order, $orderBy, $limit,OffsetPaginationUtil::calculate($limit,$page));
	    
	    $totalItem = $counter->__invoke($filters, $order, $orderBy, $limit,OffsetPaginationUtil::calculate($limit,$page));
	
	    $totalNumberOfPages = TotalNumberOfPagesUtil::calculate($page, $limit,$totalItem);
	
	    return $this->render(TwigTemplateConstants::LIST_FILE_PATH, [
	        'page_title' => TwigTemplateConstants::SECTION_TITLE,
	        'list_path' =>TwigTemplateConstants::LIST_PATH,
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
	        'nextPage' => NextPage::calculate($page,$totalNumberOfPages),
	        'previousPage' => PreviousPage::calculate($page),
	        'totalPage' => $totalNumberOfPages,
            'totalItem' => $totalItem,
            'roles' => $roleRepository->searchAll(),
            'users' => $users
        ]);
    }

    private function toggleSort( $sort):string
    {
        return $sort === 'asc' ? 'desc' : 'asc';
    }

    private function filters(?string $stringOfFilterArrayStruct): array
    {
        if($stringOfFilterArrayStruct === null){
            return array();
        }

        parse_str($stringOfFilterArrayStruct);

        if (!isset($filters)) {
            return array();
        }

        return $filters;
    }
}
