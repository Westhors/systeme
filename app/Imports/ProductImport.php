<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class ProductImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {

            foreach ($rows as $row) {

                $stock = $row['stock'] ?? 0;
                $cost  = $row['cost'] ?? 0;

                Product::create([
                    'name'       => $row['name'],
                    'sku'        => $row['sku'],
                    'stock'      => $stock,
                    'cost'       => $cost,
                    'total'      => $stock * $cost, // ✅ القيمة الإجمالية تلقائي
                    'date'       => now(), // ✅ التاريخ تلقائي
                ]);
            }

        });
    }
}
