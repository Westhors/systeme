<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Requests\DeleveryManRequest;
use App\Http\Resources\DeleveryManResource;
use App\Interfaces\DeleveryManRepositoryInterface;
use App\Models\DeleveryMan;
use Exception;
use Illuminate\Http\Request;

class DeleveryManController extends BaseController
{

    protected mixed $crudRepository;

    public function __construct(DeleveryManRepositoryInterface $pattern)
    {
        $this->crudRepository = $pattern;
    }

    public function index()
    {
        try {
            $employee = DeleveryManResource::collection($this->crudRepository->all(
                [],
                [],
                ['*']
            ));
            return $employee->additional(JsonResponse::success());
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function store(DeleveryManRequest $request)
    {
        try {
            $employee = $this->crudRepository->create($request->validated());
            return new DeleveryManResource($employee);
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function show(DeleveryMan $deleveryMan): ?\Illuminate\Http\JsonResponse
    {
        try {
            return JsonResponse::respondSuccess('Item Fetched Successfully', new DeleveryManResource($deleveryMan));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function update(DeleveryManRequest $request, DeleveryMan $deleveryMan)
    {
        try {
            $this->crudRepository->update($request->validated(), $deleveryMan->id);
            activity()->performedOn($deleveryMan)->withProperties(['attributes' => $deleveryMan])->log('update');
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function destroy(Request $request): ?\Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->deleteRecords('delevery_men', $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function restore(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->restoreItem(DeleveryMan::class, $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_RESTORED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }




    public function forceDelete(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->deleteRecordsFinial(DeleveryMan::class, $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_FORCE_DELETED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

}
