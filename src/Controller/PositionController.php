<?php

namespace App\Controller;

use App\Service\PositionService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PositionController
{
    /**
     * @var PositionService
     */
    private $positionService;

    /**
     * PositionService constructor.
     * @param PositionService $sumService
     */
    public function __construct(PositionService $sumService)
    {
        $this->positionService = $sumService;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function getByIdAction(int $id): JsonResponse
    {
        try {
            $position = $this->positionService->getPositionById($id);
            return new JsonResponse(
                $position->toArray(),
                Response::HTTP_OK
            );
        } catch (\Throwable $e) {
            return $this->handleErrorResponse($e);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getByFiltersAction(Request $request): JsonResponse
    {
        $filters = $this->getFilterList($request);
        try {
            $positions = $this->positionService->getPositionsByFilters($filters);
            $result = [];
            foreach ($positions as $position) {
                $result[] = $position->toArray();
            }
            return new JsonResponse(
                ["Positions" => $result],
                Response::HTTP_OK
            );
        } catch (\Throwable $e) {
            return $this->handleErrorResponse($e);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getBestMatchAction(Request $request): JsonResponse
    {
        try {
            $filters = $this->getFilterList($request);
            $filtersArr = array_map("trim", explode(",", $filters["skills"]));
            $filters["skills"] = $filtersArr;

            $position = $this->positionService->getPositionByMatch($filters);
            if (is_null($position)) {
                return new JsonResponse(
                    ["Error" => "No suitable positions"],
                    Response::HTTP_OK
                );
            }

            return new JsonResponse(
                $position->toArray(),
                Response::HTTP_OK
            );
        } catch (\Throwable $e) {
            return $this->handleErrorResponse($e);
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    private function getFilterList(Request $request): array
    {
        $params = $request->query->all();

        $filters = [];
        foreach ($params as $paramKey => $paramValue) {
            $key = quotemeta($paramKey);
            $value = quotemeta($paramValue);
            $filters[$key] = $value;
        }
        return $filters;
    }

    /**
     * @param \Throwable $e
     * @return JsonResponse
     */
    private function handleErrorResponse(\Throwable $e): JsonResponse
    {
        $data = ['Error' => $e->getMessage()];
        if ($e instanceof NotFoundHttpException) {
            return new JsonResponse(
                $data,
                $e->getStatusCode()
            );
        }

        return new JsonResponse(
            $data,
            500
        );
    }
}
