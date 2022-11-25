<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopicRequest extends FormRequest
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
            'name' => 'required|unique:topics,name,' . $this->name . ',name',
            'description' => 'nullable',
            'is_active' => 'required',
            'resource_link' => 'nullable',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => true,
        ]);
    }
}
