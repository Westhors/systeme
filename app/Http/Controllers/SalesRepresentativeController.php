<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Requests\SalesRepresentativeRequest;
use App\Http\Resources\SalesRepresentativeResource;
use App\Interfaces\SalesRepresentativeRepositoryInterface;
use App\Models\SalesRepresentative;
use Exception;
use Illuminate\Http\Request;

class SalesRepresentativeController extends BaseController
{

    protected mixed $crudRepository;

    public function __construct(SalesRepresentativeRepositoryInterface $pattern)
    {
        $this->crudRepository = $pattern;
    }

    public function index()
    {
        try {
            $salesRepresentative = SalesRepresentativeResource::collection($this->crudRepository->all(
                [],
                [],
                ['*']
            ));
            return $salesRepresentative->additional(JsonResponse::success());
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function store(SalesRepresentativeRequest $request)
    {
        try {
            $salesRepresentative = $this->crudRepository->create($request->validated());
            return new SalesRepresentativeResource($salesRepresentative);
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function show(SalesRepresentative $salesRepresentative): ?\Illuminate\Http\JsonResponse
    {
        try {
            return JsonResponse::respondSuccess('Item Fetched Successfully', new SalesRepresentativeResource($salesRepresentative));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function update(SalesRepresentativeRequest $request, SalesRepresentative $salesRepresentative)
    {
        try {
            $this->crudRepository->update($request->validated(), $salesRepresentative->id);
            activity()->performedOn($salesRepresentative)->withProperties(['attributes' => $salesRepresentative])->log('update');
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function destroy(Request $request): ?\Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->deleteRecords('sales_representatives', $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function restore(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->restoreItem(SalesRepresentative::class, $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_RESTORED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }




    public function forceDelete(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->deleteRecordsFinial(SalesRepresentative::class, $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_FORCE_DELETED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

}
