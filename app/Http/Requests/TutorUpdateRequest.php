<?php

namespace App\Http\Requests;

use App\Models\Type;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TutorUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        // dd($this->request);
        return [
            'school_id' => 'required|exists:cycles,school_id',
            'type_id' => 'required|exists:types,id',
            'cycle' => 'required|exists:cycles,name',
            'names' => 'required',
            'last_names' => 'required',
            'code' => 'required|numeric|unique:people,code,' . $this->code . ',code',
            'email' => 'required|email|unique:people,email,' . $this->email . ',email',
            'gender' => 'required|in:Masculino,Femenino',
            'phone' => 'required|numeric|unique:people,phone,' . $this->phone . ',phone',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'type_id' => Type::TUTOR,
        ]);
    }
}
