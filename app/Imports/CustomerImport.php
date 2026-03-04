<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class CustomerImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {

            foreach ($rows as $row) {

                if (empty($row['name'])) {
                    continue; // تجاهل الصف لو الاسم فاضي
                }

                Customer::updateOrCreate(
                    [
                        'phone' => $row['phone'] // المفتاح الأساسي للتحديث
                    ],
                    [
                        'name'    => $row['name'],
                        'email'   => $row['email'],
                        'address' => $row['address'],
                        'notes'   => $row['notes'],
                    ]
                );
            }

        });
    }
}
