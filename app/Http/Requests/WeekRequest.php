<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class WeekRequest extends FormRequest
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
            // 'name' => 'required',
            'event_date' => 'required|date|unique:weeks'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'event_date' => Carbon::parse(now())->next(Carbon::FRIDAY),
        ]);
    }

    public function messages()
    {
        return [
            'event_date.unique' => 'Ya existen temas registrados para esta semana.',
        ];
    }
}
