<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('employee') ? $this->route('employee')->id : null;

        return [
            'employee_code' => 'required|string|max:100|unique:employees,employee_code,' . $id,
            'name'          => 'required|string|max:255',
            'position'      => 'nullable|string|max:255',
            'department'    => 'nullable|string|max:255',
            'role_id'       => 'required|exists:roles,id',
            'phone'         => 'nullable|string|max:20',
            'email'         => 'nullable|email|unique:employees,email,' . $id,
            'salary'        => 'nullable|numeric|min:0',
            'password'      => $this->isMethod('post') ? 'required|string|min:6' : 'nullable|string|min:6',
        ];
    }


    public function messages(): array
    {
        return [
            'employee_code.required' => 'كود الموظف مطلوب',
            'employee_code.unique'   => 'كود الموظف مستخدم بالفعل',
            'email.unique'           => 'البريد الإلكتروني مستخدم بالفعل',
            'salary.numeric'         => 'الراتب يجب أن يكون رقمًا صحيحًا',
            'password.min'           => 'كلمة المرور يجب أن تكون على الأقل 6 أحرف',
        ];
    }
}


