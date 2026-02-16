<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Interfaces\RoleRepositoryInterface;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;

class RoleController extends BaseController
{

    protected mixed $crudRepository;

    public function __construct(RoleRepositoryInterface $pattern)
    {
        $this->crudRepository = $pattern;
    }

    public function index()
    {
        try {
            $roles = $this->crudRepository->all();
            return JsonResponse::respondSuccess('Items Fetched Successfully', $roles);
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    // public function store(SupplierRequest $request)
    // {
    //     try {
    //         $supplier = $this->crudRepository->create($request->validated());
    //         return new SupplierResource($supplier);
    //     } catch (Exception $e) {
    //         return JsonResponse::respondError($e->getMessage());
    //     }
    // }

    // public function show(Supplier $supplier): ?\Illuminate\Http\JsonResponse
    // {
    //     try {
    //         return JsonResponse::respondSuccess('Item Fetched Successfully', new SupplierResource($supplier));
    //     } catch (Exception $e) {
    //         return JsonResponse::respondError($e->getMessage());
    //     }
    // }


    // public function update(SupplierRequest $request, Supplier $supplier)
    // {
    //     try {
    //         $this->crudRepository->update($request->validated(), $supplier->id);
    //         activity()->performedOn($supplier)->withProperties(['attributes' => $supplier])->log('update');
    //         return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY));
    //     } catch (Exception $e) {
    //         return JsonResponse::respondError($e->getMessage());
    //     }
    // }


    public function destroy(Request $request): ?\Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->deleteRecords('roles', $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function restore(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->restoreItem(Role::class, $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_RESTORED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }




    public function forceDelete(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->deleteRecordsFinial(Role::class, $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_FORCE_DELETED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

}
