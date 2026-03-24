<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Requests\TreasuryRequest;
use App\Http\Resources\TreasuryResource;
use App\Interfaces\TreasuryRepositoryInterface;
use App\Models\Treasury;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TreasuryController extends BaseController
{
    protected mixed $crudRepository;

    public function __construct(TreasuryRepositoryInterface $pattern)
    {
        $this->crudRepository = $pattern;
    }

    public function index()
    {
        try {
            $treasuries = $this->crudRepository->all(
                [],
                ['branch'],
                ['*']
            );

            return TreasuryResource::collection($treasuries)
                ->additional(JsonResponse::success());

        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function store(TreasuryRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            // التحقق من العملات
            if (isset($data['currencies']) && is_array($data['currencies'])) {
                foreach ($data['currencies'] as $currency) {
                    if (!isset($currency['currency_id']) || $currency['currency_id'] <= 0) {
                        throw new Exception('Invalid currency ID');
                    }
                }
            }

            // تجهيز البيانات للحفظ
            $treasuryData = [
                'name' => $data['name'],
                'code' => $data['code'] ?? null,
                'branch_id' => $data['branch_id'] ?? null,
                'is_main' => $data['is_main'] ?? false,
                'notes' => $data['notes'] ?? null,
                'currencies' => $data['currencies'] ?? [],
            ];

            $treasury = $this->crudRepository->create($treasuryData);

            DB::commit();

            return JsonResponse::respondSuccess(
                trans(JsonResponse::MSG_ADDED_SUCCESSFULLY),
                new TreasuryResource($treasury->load('branch'))
            );

        } catch (ValidationException $e) {
            DB::rollBack();
            return JsonResponse::respondError($e->getMessage(), $e->errors());
        } catch (Exception $e) {
            DB::rollBack();
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function show(Treasury $treasury)
    {
        try {
            $treasury->load('branch');

            return JsonResponse::respondSuccess(
                'Item Fetched Successfully',
                new TreasuryResource($treasury)
            );

        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function update(TreasuryRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            // التحقق من العملات
            if (isset($data['currencies']) && is_array($data['currencies'])) {
                foreach ($data['currencies'] as $currency) {
                    if (!isset($currency['currency_id']) || $currency['currency_id'] <= 0) {
                        throw new Exception('Invalid currency ID');
                    }
                }
            }

            // تجهيز البيانات للتحديث
            $treasuryData = [
                'name' => $data['name'],
                'code' => $data['code'] ?? null,
                'branch_id' => $data['branch_id'] ?? null,
                'is_main' => $data['is_main'] ?? false,
                'notes' => $data['notes'] ?? null,
            ];

            // تحديث العملات لو موجودة
            if (isset($data['currencies'])) {
                $treasuryData['currencies'] = $data['currencies'];
            }

            // التحقق من عدم تكرار الكود (باستثناء نفس السجل)
            if (isset($data['code']) && !empty($data['code'])) {
                $existingTreasury = Treasury::where('code', $data['code'])
                    ->where('id', '!=', $id)
                    ->first();

                if ($existingTreasury) {
                    throw ValidationException::withMessages([
                        'code' => ['الكود مستخدم بالفعل في خزينة أخرى']
                    ]);
                }
            }

            $this->crudRepository->update($treasuryData, $id);

            $treasury = Treasury::with('branch')->find($id);

            activity()
                ->performedOn($treasury)
                ->withProperties(['attributes' => $treasury])
                ->log('update');

            DB::commit();

            return JsonResponse::respondSuccess(
                trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY),
                new TreasuryResource($treasury)
            );

        } catch (ValidationException $e) {
            DB::rollBack();
            return JsonResponse::respondError($e->getMessage(), $e->errors());
        } catch (Exception $e) {
            DB::rollBack();
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $this->crudRepository->deleteRecords('treasuries', $request['items']);

            return JsonResponse::respondSuccess(
                trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)
            );

        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function restore(Request $request)
    {
        try {
            $this->crudRepository->restoreItem(Treasury::class, $request['items']);

            return JsonResponse::respondSuccess(
                trans(JsonResponse::MSG_RESTORED_SUCCESSFULLY)
            );

        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function forceDelete(Request $request)
    {
        try {
            $this->crudRepository->deleteRecordsFinial(Treasury::class, $request['items']);

            return JsonResponse::respondSuccess(
                trans(JsonResponse::MSG_FORCE_DELETED_SUCCESSFULLY)
            );

        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
