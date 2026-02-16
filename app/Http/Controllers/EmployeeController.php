<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Interfaces\EmployeeRepositoryInterface;
use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends BaseController
{

    protected mixed $crudRepository;

    public function __construct(EmployeeRepositoryInterface $pattern)
    {
        $this->crudRepository = $pattern;
    }

    public function index()
    {
        try {
            $employee = EmployeeResource::collection($this->crudRepository->all(
                [],
                [],
                ['*']
            ));
            return $employee->additional(JsonResponse::success());
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
    public function store(EmployeeRequest $request)
    {
        try {
            $data = $request->validated();

            // تشفير كلمة المرور قبل الحفظ
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $employee = $this->crudRepository->create($data);

            return new EmployeeResource($employee);
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function show(Employee $employee): ?\Illuminate\Http\JsonResponse
    {
        try {
            return JsonResponse::respondSuccess('Item Fetched Successfully', new EmployeeResource($employee));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


  public function update(EmployeeRequest $request, Employee $employee)
    {
        try {
            $data = $request->validated();

            // تشفير كلمة المرور إذا موجودة
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            // تحديث الموظف
            $this->crudRepository->update($data, $employee->id);

            // تسجيل النشاط
            activity()->performedOn($employee)->withProperties(['attributes' => $employee])->log('update');

            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }



    public function destroy(Request $request): ?\Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->deleteRecords('employees', $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function restore(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->restoreItem(Employee::class, $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_RESTORED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }




    public function forceDelete(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->deleteRecordsFinial(Employee::class, $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_FORCE_DELETED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

}
