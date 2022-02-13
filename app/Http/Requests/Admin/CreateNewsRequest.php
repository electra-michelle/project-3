<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateNewsRequest extends FormRequest
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

    public function prepareForValidation()
    {
        $this->merge([
            'content' => clean($this->content),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title' => ['required', 'array'],
            'published_from' => ['nullable', 'date', 'date_format:Y-m-d H:i:s'],
            'content' => ['required', 'array'],
            'image' => ['required', 'image'],
        ];

        foreach(config('app.locales') as $key => $locale) {
            $rules['title.'. $key] = ['required', 'string', 'max:255'];
            $rules['content.' . $key] = ['required', 'string'];
        }

        return $rules;
    }
}
