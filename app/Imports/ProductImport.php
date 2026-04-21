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
                $cost  = (float) str_replace(',', '', $row['cost'] ?? 0);
                $price = (float) str_replace(',', '', $row['price'] ?? 0);

                $barcode = !empty($row['barcode'])
                    ? trim($row['barcode'])
                    : null;

                Product::create([
                    'name'       => $row['name'],
                    'sku'        => $row['sku'],
                    'price'      => $price,
                    'barcode'    => $barcode,
                    'stock'      => $stock,
                    'beginning_balance' => 1,
                    'cost'       => $cost,
                ]);
            }

        });
    }
}
