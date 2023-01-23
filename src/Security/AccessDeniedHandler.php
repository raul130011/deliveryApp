<?php

namespace App\Security;

use App\Service\App\ApiResponseService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    /** @var ApiResponseService $apiResponse*/
    private $apiResponse;

    /** @param ApiResponseService $apiResponse */
    public function __construct(ApiResponseService $apiResponse)
    {
        $this->apiResponse = $apiResponse;
    }

    /**
     * @param Request $request
     * @param AccessDeniedException $accessDeniedException
     * @return JsonResponse|Response|null
     */
    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        return $this->apiResponse->getCustomResponse(
            false,
            Response::HTTP_FORBIDDEN,
            'Access denied You are not authorized to access this resources.'
        );
    }
}