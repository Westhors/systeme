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

            $offer = $this->crudRepository->create($data);

            if (isset($data['product_ids'])) {
                $offer->products()->sync($data['product_ids']);
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

            $this->crudRepository->update($data, $offer->id);

            if (isset($data['product_ids'])) {
                $offer->products()->sync($data['product_ids']);
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

}
