<?php

namespace App\Http\Requests;

use App\Models\Type;
use Illuminate\Foundation\Http\FormRequest;

class TutorStoreRequest extends FormRequest
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
        return [
            'school_id' => 'required|exists:cycles,school_id',
            'type_id' => 'required|exists:types,id',
            'cycle' => 'required|exists:cycles,name',
            'names' => 'required',
            'last_names' => 'required',
            'code' => 'required|numeric|unique:people',
            'email' => 'required|email|unique:people',
            'gender' => 'required|in:Masculino,Femenino',
            'phone' => 'required|numeric|unique:people',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'type_id' => Type::TUTOR,
        ]);
    }
}
