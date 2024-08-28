<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeriesFormRequest extends FormRequest
{
    public string $name;
    public int $seasonsQty;
    public int $episodesPerSeason;

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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'min:3'],
            'seasonsQty' => ['required', 'integer', 'min:1', 'max:30'],
            'episodesPerSeason' => ['required', 'integer', 'min:1', 'max:30'],
            'cover' => ['file', 'image']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "The field 'name' is required",
            'name.min' => "The field 'name' must have at least :min characters",
            'seasonsQty.required' => "The field 'number of seasons' is required",
            'seasonsQty.integer' => "The field 'number of seasons' must be a number",
            'seasonsQty.min' => "The field 'number of seasons' must be at least :min",
            'seasonsQty.max' => "The field 'number of seasons' must not exceed :max",
            'episodesPerSeason.required' => "The field 'episodes per season' is required",
            'episodesPerSeason.integer' => "The field 'episodes per season' must be a number",
            'episodesPerSeason.min' => "The field 'episodes per season' must be at least :min",
            'episodesPerSeason.max' => "The field 'episodes per season' must not exceed :max",
            'cover.file' => "The field 'cover' must be a file",
            'cover.image' => "The 'cover' file must be an image"
        ];
    }
}
