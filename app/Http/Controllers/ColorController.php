<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Requests\ColorRequest;
use App\Http\Resources\ColorResource;
use App\Interfaces\ColorRepositoryInterface;
use App\Models\Color;
use Exception;
use Illuminate\Http\Request;

class ColorController extends BaseController
{

    protected mixed $crudRepository;

    public function __construct(ColorRepositoryInterface $pattern)
    {
        $this->crudRepository = $pattern;
    }

    public function index()
    {
        try {
            $color = ColorResource::collection($this->crudRepository->all(
                [],
                [],
                ['*']
            ));
            return $color->additional(JsonResponse::success());
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function store(ColorRequest $request)
    {
        try {
            $color = $this->crudRepository->create($request->validated());
            return new ColorResource($color);
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function show(Color $color): ?\Illuminate\Http\JsonResponse
    {
        try {
            return JsonResponse::respondSuccess('Item Fetched Successfully', new ColorResource($color));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function update(ColorRequest $request, Color $color)
    {
        try {
            $this->crudRepository->update($request->validated(), $color->id);
            activity()->performedOn($color)->withProperties(['attributes' => $color])->log('update');
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function destroy(Request $request): ?\Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->deleteRecords('colors', $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function restore(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->restoreItem(Color::class, $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_RESTORED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }




    public function forceDelete(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->deleteRecordsFinial(Color::class, $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_FORCE_DELETED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

}
