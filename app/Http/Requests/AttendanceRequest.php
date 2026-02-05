<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->attendance?->id;

        return [
            'employee_id' => [
                'required',
                'exists:employees,id',
                Rule::unique('attendances')
                    ->where(fn($q) => $q->where('date', $this->date))
                    ->ignore($id)
            ],

            'date'      => 'required|date',
            'check_in'  => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i|after:check_in',
            'status'    => 'required|in:present,late,absent,on_leave',
        ];
    }

    public function messages(): array
    {
        return [
            'employee_id.required' => 'الموظف مطلوب',
            'employee_id.unique'   => 'تم تسجيل حضور الموظف بالفعل في هذا اليوم',
            'check_out.after'      => 'وقت الانصراف يجب أن يكون بعد وقت الحضور',
        ];
    }
}
