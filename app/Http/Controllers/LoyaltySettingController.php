<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Requests\LoyaltySettingRequest;
use App\Http\Resources\LoyaltySettingResource;
use App\Interfaces\LoyaltySettingRepositoryInterface;
use App\Models\LoyaltySetting;
use Exception;
use Illuminate\Http\Request;

class LoyaltySettingController extends BaseController
{

    protected mixed $crudRepository;

    public function __construct(LoyaltySettingRepositoryInterface $pattern)
    {
        $this->crudRepository = $pattern;
    }

    public function index()
    {
        try {
            $Loyalty = LoyaltySettingResource::collection($this->crudRepository->all(
                [],
                [],
                ['*']
            ));
            return $Loyalty->additional(JsonResponse::success());
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function store(LoyaltySettingRequest $request)
    {
        try {
            $employee = $this->crudRepository->create($request->validated());
            return new LoyaltySettingResource($employee);
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function show(LoyaltySetting $loyalty_point): ?\Illuminate\Http\JsonResponse
    {
        try {
            return JsonResponse::respondSuccess('Item Fetched Successfully', new LoyaltySettingResource($loyalty_point));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function update(LoyaltySettingRequest $request, LoyaltySetting $loyalty_point)
    {
        try {
            $this->crudRepository->update($request->validated(), $loyalty_point->id);
            activity()->performedOn($loyalty_point)->withProperties(['attributes' => $loyalty_point])->log('update');
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function destroy(Request $request): ?\Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->deleteRecords('loyalty_settings', $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function restore(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->restoreItem(LoyaltySetting::class, $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_RESTORED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }




    public function forceDelete(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->deleteRecordsFinial(LoyaltySetting::class, $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_FORCE_DELETED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

}
