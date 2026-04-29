<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            $mainWarehouse = Warehouse::where('main_branch', true)->first();
            if (!$mainWarehouse) {
                throw new \Exception('Main warehouse not found');
            }
            foreach ($rows as $row) {

                $stock = (int) ($row['stock'] ?? 0);
                $cost  = (float) str_replace(',', '', $row['cost'] ?? 0);

                $product = Product::updateOrCreate(
                    ['sku' => trim($row['sku'])],
                    [
                        'name'       => trim($row['name']),
                        'price'      => (float) str_replace(',', '', $row['price'] ?? 0),
                        'barcode'    => !empty($row['barcode']) ? trim($row['barcode']) : null,
                        'stock'      => $stock,
                        'beginning_balance' => 1,
                        'cost'       => $cost,
                    ]
                );

                // اربط المنتج بالمخزن الرئيسي
                $product->warehouses()->syncWithoutDetaching([
                    $mainWarehouse->id => [
                        'stock' => $stock,
                        'cost'  => $cost,
                    ]
                ]);
            }
        });
    }
}
