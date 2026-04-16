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

                $stock = $row['الكمية'] ?? 0;
                $cost  = $row['سعر_التكلفة'] ?? 0;

                Product::create([
                    'name'       => $row['اسم_المنتج'] ?? null,
                    'sku'        => $row['sku'] ?? null,
                    'price'      => $row['price'] ?? 0,
                    'barcode'    => $row['barcode'] ?? null,
                    'stock'      => $stock,
                    'beginning_balance' => 1,
                    'cost'       => $cost,
                    'total'      => $stock * $cost,
                    'date'       => now(),
                ]);
            }

        });
    }
}
