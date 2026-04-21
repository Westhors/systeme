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

                $stock = (int) ($row['stock'] ?? 0);
                $cost  = (float) ($row['cost'] ?? 0);
                $price = (float) ($row['price'] ?? 0);

                Product::create([
                    'name'       => $row['name'],
                    'sku'        => $row['sku'],
                    'price'      => $price,
                    'barcode'    => (string) $row['barcode'],
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
