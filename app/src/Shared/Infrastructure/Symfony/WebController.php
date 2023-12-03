<?php

namespace App\Shared\Infrastructure\Symfony;

use App\Shared\Infrastructure\Constant\MessageConstant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;

abstract class WebController extends AbstractController
{
    public function redirectWithMessage(string $routeName, string $message): RedirectResponse
    {
        $this->addFlash('message', $message);

        return $this->redirectToRoute($routeName);
    }

    public function redirectWithSuccessCreateMessage( string $routeName): RedirectResponse
    {
        return $this->redirectWithMessage($routeName,MessageConstant::SUCCESS_MESSAGE_TO_CREATE);
    }

    public function redirectWithSuccessUpdateMessage( string $routeName): RedirectResponse
    {
        return $this->redirectWithMessage($routeName,MessageConstant::SUCCESS_MESSAGE_TO_UPDATE);
    }

    public function redirectOnInvalidCsrfToken(): RedirectResponse
    {
        return $this->redirectWithMessage('error_page', MessageConstant::INVALID_TOKEN_CSFR_MESSAGE);
    }

    public function redirectWithErrors(
        string                           $routeName,
        ConstraintViolationListInterface $errors,
        Request                          $request
    ): RedirectResponse
    {
        $this->addFlashFor('hasErrors', [true]);
        $this->addFlashFor('errors', $this->formatFlashErrors($errors));
        $this->addFlashFor('inputs', $request->request->all());

        if ($this->isARouteToCreateAnItem($routeName)) {
            return $this->redirectToRoute($routeName, ['id' => $request->get('id')]);
        }

        return $this->redirectToRoute($routeName);
    }

    private function formatFlashErrors(ConstraintViolationListInterface $violations): array
    {
        $errors = [];
        foreach ($violations as $violation) {
            $errors[str_replace(['[', ']'], ['', ''], $violation->getPropertyPath())] = $violation->getMessage();
        }

        return $errors;
    }

    private function addFlashFor(string $prefix, array $messages): void
    {
        foreach ($messages as $key => $message) {
            $this->addFlash($prefix . '.' . $key, $message);
        }
    }

    /**
     * @param string $routeName
     * @return bool
     */
    private function isARouteToCreateAnItem(string $routeName): bool
    {
        return strpos($routeName, "edit") !== false;
    }

    protected function jsonResponseOnInvalidCsrfToken(): JsonResponse
    {
        return new JsonResponse([
            'status'  => 'fail_invalid_csrf_token',
            'message' => MessageConstant::INVALID_TOKEN_CSFR_MESSAGE
        ]);
    }

    protected function jsonResponseSuccess(): JsonResponse
    {
        return new JsonResponse(['status' => 'success']);
    }

    protected function jsonResponseUnexpectedErrorOnDelete(): JsonResponse
    {
        return $this->jsonResponseFail(MessageConstant::UNEXPECTED_ERROR_HAS_OCCURRED_ON_DELETE);
    }

    protected function jsonResponseFail(string $message): JsonResponse
    {
        return new JsonResponse([
            'status'  => 'fail',
            'message' => $message
        ]);
    }


}
