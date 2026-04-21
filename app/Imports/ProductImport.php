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

                Product::updateOrCreate(
                    ['sku' => trim($row['sku'])],
                    [
                        'name'       => trim($row['name']),
                        'price'      => (float) str_replace(',', '', $row['price'] ?? 0),
                        'barcode'    => !empty($row['barcode']) ? trim($row['barcode']) : null,
                        'stock'      => (int) ($row['stock'] ?? 0),
                        'beginning_balance' => 1,
                        'cost'       => (float) str_replace(',', '', $row['cost'] ?? 0),
                    ]
                );
            }

        });
    }
}
