<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with(['causer']);

        if ($request->model) {
            $query->where('subject_type', $request->model);
        }

        if ($request->event) {
            $query->where('event', $request->event);
        }

        $logs = $query->latest()->paginate(20);

        return response()->json([
            'status' => true,
            'data' => $logs
        ]);
    }
}
