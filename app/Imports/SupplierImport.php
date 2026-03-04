<?php

namespace App\Imports;

use App\Models\Supplier;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class SupplierImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {

            foreach ($rows as $row) {

                if (empty($row['name'])) {
                    continue; // تجاهل الصف لو الاسم فاضي
                }

                Supplier::updateOrCreate(
                    [
                        'phone' => $row['phone'] // منع تكرار نفس الرقم
                    ],
                    [
                        'name'           => $row['name'],
                        'address'        => $row['address'],
                        'contact_person' => $row['contact_person'],
                    ]
                );
            }

        });
    }
}
