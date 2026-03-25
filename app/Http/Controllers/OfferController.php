<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Requests\OfferRequest;
use App\Http\Resources\OfferResource;
use App\Interfaces\OfferRepositoryInterface;
use App\Models\Offer;
use Exception;
use Illuminate\Http\Request;

class OfferController extends BaseController
{

    protected mixed $crudRepository;

    public function __construct(OfferRepositoryInterface $pattern)
    {
        $this->crudRepository = $pattern;
    }

    public function index()
    {
        try {
            $offer = OfferResource::collection($this->crudRepository->all(
                [],
                [],
                ['*']
            ));
            return $offer->additional(JsonResponse::success());
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function store(OfferRequest $request)
    {
        try {
            $data = $request->validated();

            // 🔥 فصل المنتجات
            $productIds = $data['product_ids'] ?? [];
            unset($data['product_ids']);

            // إنشاء العرض
            $offer = $this->crudRepository->create($data);

            // ربط المنتجات
            if (!empty($productIds)) {
                $offer->products()->sync($productIds);
            }

            activity()
                ->performedOn($offer)
                ->withProperties(['attributes' => $data])
                ->log('create');

            return new OfferResource($offer->load('products'));

        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
    public function show(Offer $offer): ?\Illuminate\Http\JsonResponse
    {
        try {
            return JsonResponse::respondSuccess('Item Fetched Successfully', new OfferResource($offer));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function update(OfferRequest $request, Offer $offer)
    {
        try {
            $data = $request->validated();

            // 🔥 فصل المنتجات
            $productIds = $data['product_ids'] ?? null;
            unset($data['product_ids']);

            // تحديث العرض
            $this->crudRepository->update($data, $offer->id);

            // مزامنة المنتجات
            if (!is_null($productIds)) {
                $offer->products()->sync($productIds);
            }

            activity()
                ->performedOn($offer)
                ->withProperties(['attributes' => $data])
                ->log('update');

            return new OfferResource($offer->refresh()->load('products'));

        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }



    public function destroy(Request $request): ?\Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->deleteRecords('offers', $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function restore(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->restoreItem(Offer::class, $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_RESTORED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }




    public function forceDelete(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->deleteRecordsFinial(Offer::class, $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_FORCE_DELETED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function reports()
    {
        try {
            $now = now();

            return JsonResponse::respondSuccess([
                'total_offers'     => Offer::count(),
                'active_offers'    => Offer::where('active', true)
                    ->whereRaw(
                        "CONCAT(start_date, ' ', start_time) <= ?
                        AND CONCAT(end_date, ' ', end_time) >= ?",
                        [$now, $now]
                    )->count(),

                'scheduled_offers' => Offer::whereRaw(
                    "CONCAT(start_date, ' ', start_time) > ?",
                    [$now]
                )->count(),

                'expired_offers'   => Offer::whereRaw(
                    "CONCAT(end_date, ' ', end_time) < ?",
                    [$now]
                )->count(),
            ]);

        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


}
