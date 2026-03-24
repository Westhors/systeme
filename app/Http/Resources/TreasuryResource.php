<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TreasuryResource extends JsonResource
{
    public function toArray($request)
    {
        // Debug: نشوف إيه جاي من الموديل
        \Log::info('TreasuryResource - Raw currencies:', [
            'id' => $this->id,
            'currencies_raw' => $this->attributes['currencies'] ?? null,
            'currencies_cast' => $this->currencies,
        ]);

        // نجيب الـ currencies من الموديل
        $currencies = $this->currencies ?? [];

        // نتأكد إنها array
        if (is_string($currencies)) {
            $currencies = json_decode($currencies, true) ?? [];
        }

        // نتأكد إنها مش null
        if (empty($currencies)) {
            $currencies = [];
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'branch_id' => $this->branch_id,
            'branch' => new BranchResource($this->whenLoaded('branch')),
            'is_main' => (bool)$this->is_main,
            'notes' => $this->notes,

            // الأرصدة متعددة العملات
            'currencies' => $this->formatCurrencies($currencies),

            // للتوافق مع الإصدارات القديمة
            'currency' => !empty($currencies) ? ($currencies[0]['currency_id'] ?? null) : null,
            'balance' => !empty($currencies) ? (float)($currencies[0]['balance'] ?? 0) : 0,

            // إجمالي الرصيد
            'total_balance' => collect($currencies)->sum('balance'),

            'created_at' => $this->created_at?->toDateTimeString(),
            'created_at_formatted' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }

    private function formatCurrencies($currencies)
    {
        if (empty($currencies) || !is_array($currencies)) {
            return [];
        }

        return collect($currencies)->map(function ($currency) {
            // تأكد من وجود البيانات المطلوبة
            if (!isset($currency['currency_id'])) {
                return null;
            }

            return [
                'currency_id' => (int)($currency['currency_id'] ?? 0),
                'balance' => (float)($currency['balance'] ?? 0),
                'is_main' => (bool)($currency['is_main'] ?? false),
                'balance_formatted' => number_format($currency['balance'] ?? 0, 2) . ' ' . ($currency['currency_code'] ?? ''),
            ];
        })->filter()->values()->toArray();
    }
}
