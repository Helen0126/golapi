<?php

namespace App\Http\Requests;

use App\Models\Role;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class GolStoreRequest extends FormRequest
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
            // 'school_id' => 'required|exists:cycles,school_id',
            'cycle_id' => 'required|exists:cycles,id|unique:gols,cycle_id',
            'name' => 'required|unique:gols',
            'chant' => 'required',
            'motto' => 'required',
            'verse' => 'required',
            'photo' => 'nullable|image',
        ];
    }

    protected function prepareForValidation()
    {
        if (Auth::user()->hasRole(Role::TUTOR)) {
            $this->merge([
                'cycle_id' => Auth::user()->person->cycle->id,
            ]);
        }
    }
}
