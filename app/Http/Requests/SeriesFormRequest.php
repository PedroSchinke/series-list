<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeriesFormRequest extends FormRequest
{
    public string $name;
    public int $seasons_qty;
    public int $episodes_per_season;

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
            'seasons_qty' => ['required', 'integer', 'min:1', 'max:30'],
            'episodes_per_season' => ['required', 'integer', 'min:1', 'max:30'],
            'cover' => ['file', 'image']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "The field 'name' is required",
            'name.min' => "The field 'name' must have at least :min characters",
            'seasons_qty.required' => "The field 'number of seasons' is required",
            'seasons_qty.integer' => "The field 'number of seasons' must be a number",
            'seasons_qty.min' => "The field 'number of seasons' must be at least :min",
            'seasons_qty.max' => "The field 'number of seasons' must not exceed :max",
            'episodes_per_season.required' => "The field 'episodes per season' is required",
            'episodes_per_season.integer' => "The field 'episodes per season' must be a number",
            'episodes_per_season.min' => "The field 'episodes per season' must be at least :min",
            'episodes_per_season.max' => "The field 'episodes per season' must not exceed :max",
            'cover.file' => "The field 'cover' must be a file",
            'cover.image' => "The 'cover' file must be an image"
        ];
    }
}
