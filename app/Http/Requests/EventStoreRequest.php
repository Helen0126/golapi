<?php

namespace App\Http\Requests;

use App\Models\Gol;
use App\Models\Topic;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
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
            'gol_id' => 'required|exists:gols,id',
            'programmed_at' => 'required',
            // 'start_at' => 'nullable',
            // 'end_at' => 'nullable',
            // 'banner' => 'nullable',
            // 'name' => 'nullable|image',
            'status' => 'nullable',
        ];
    }

    protected function prepareForValidation()
    {
        $gol_id = Auth::user()->person->cycle->gol->id;
        $GRADE = Auth::user()->person->cycle->grade;
        $programmed_at =Topic::whereGrade($GRADE)->orderBy('event_date')->first()->week->event_date;

        $this->merge([
            'gol_id' => $gol_id,
            'programmed_at' => $programmed_at,
            'status' => 'P',
        ]);
    }
}
