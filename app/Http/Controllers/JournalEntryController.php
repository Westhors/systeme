<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JournalEntryController extends Controller
{
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            $entry = JournalEntry::create([
                'entry_date'     => $request->date,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'notes'          => $request->notes,
                'status'         => $request->status ?? 'draft',
            ]);

            $totalDebit = 0;
            $totalCredit = 0;

            foreach ($request->lines as $line) {

                $entry->lines()->create([
                    'account_id' => $line['account_id'],
                    'debit'      => $line['debit'] ?? 0,
                    'credit'     => $line['credit'] ?? 0,
                    'description'=> $line['description'] ?? null,
                ]);

                $totalDebit += $line['debit'] ?? 0;
                $totalCredit += $line['credit'] ?? 0;
            }

            if ($totalDebit != $totalCredit) {
                throw new \Exception('القيد غير متوازن');
            }
        });

        return response()->json(['message' => 'تم حفظ القيد']);
    }

    public function journalEntryIndex(Request $request)
    {
        try {

            $filters = $request->input('filters', []);
            $orderBy = $request->input('orderBy', 'journal_entries.id');
            $orderByDirection = $request->input('orderByDirection', 'desc');
            $perPage = $request->input('perPage', 10);
            $paginate = $request->boolean('paginate', true);

            $query = JournalEntry::query()
                ->leftJoin('journal_entry_lines', 'journal_entries.id', '=', 'journal_entry_lines.journal_entry_id')
                ->select(
                    'journal_entries.*',
                    \DB::raw('SUM(journal_entry_lines.debit) as total_debit'),
                    \DB::raw('SUM(journal_entry_lines.credit) as total_credit')
                )
                ->groupBy('journal_entries.id');

            // =========================
            // FILTERS
            // =========================

            if (!empty($filters['entry_number'])) {
                $query->where('journal_entries.id', 'like', '%' . $filters['entry_number'] . '%');
            }

            if (!empty($filters['status'])) {
                $query->where('journal_entries.status', $filters['status']);
            }

            if (!empty($filters['date_from'])) {
                $query->whereDate('journal_entries.entry_date', '>=', $filters['date_from']);
            }

            if (!empty($filters['date_to'])) {
                $query->whereDate('journal_entries.entry_date', '<=', $filters['date_to']);
            }

            if (!empty($filters['description'])) {
                $query->where(function ($q) use ($filters) {
                    $q->where('journal_entries.description_ar', 'like', '%' . $filters['description'] . '%')
                    ->orWhere('journal_entries.description_en', 'like', '%' . $filters['description'] . '%');
                });
            }

            // =========================
            // SORT
            // =========================

            $query->orderBy($orderBy, $orderByDirection);

            // =========================
            // PAGINATION MODE
            // =========================

            if ($paginate) {

                $entries = $query->paginate($perPage);

                return response()->json([
                    'data' => $entries->items(),

                    'links' => [
                        'first' => $entries->url(1),
                        'last' => $entries->url($entries->lastPage()),
                        'prev' => $entries->previousPageUrl(),
                        'next' => $entries->nextPageUrl(),
                    ],

                    'meta' => [
                        'current_page' => $entries->currentPage(),
                        'from' => $entries->firstItem(),
                        'last_page' => $entries->lastPage(),
                        'path' => $entries->path(),
                        'per_page' => $entries->perPage(),
                        'to' => $entries->lastItem(),
                        'total' => $entries->total(),
                    ],

                    'result' => 'Success',
                    'message' => 'Journal entries fetched successfully',
                    'status' => 200,
                ]);
            }

            // =========================
            // NON PAGINATED MODE
            // =========================

            $entries = $query->get();

            return response()->json([
                'data' => $entries,
                'links' => null,
                'meta' => null,
                'result' => 'Success',
                'message' => 'Journal entries fetched successfully',
                'status' => 200,
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'result' => 'Error',
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }
    public function reports()
    {
        $totalEntries = JournalEntry::count();

        $posted = JournalEntry::where('status', 'posted')->count();

        $drafts = JournalEntry::where('status', 'draft')->count();

        return response()->json([
            'total_entries' => $totalEntries,
            'posted'        => $posted,
            'drafts'        => $drafts,
        ]);
    }
}
