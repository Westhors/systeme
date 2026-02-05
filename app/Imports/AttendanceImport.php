<?php

namespace App\Imports;

use App\Models\Attendance;
use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class AttendanceImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $rows->shift(); // حذف الهيدر

        foreach ($rows as $row) {
            $employee = Employee::find($row[0]);
            if (!$employee) {
                continue; // تخطى إذا الموظف مش موجود
            }

            Attendance::updateOrCreate(
                [
                    'employee_id' => $row[0],
                    'date' => $row[1]
                ],
                [
                    'check_in'  => $row[2],
                    'check_out' => $row[3],
                    'status'    => $row[4] ?? 'present'
                ]
            );
        }
    }
}
