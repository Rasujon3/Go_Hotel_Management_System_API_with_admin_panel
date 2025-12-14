<?php

namespace App\Http\Requests;

use App\Models\PropertyType;
use Illuminate\Foundation\Http\FormRequest;

class PropertyTypeRequest extends FormRequest
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
        $data = $this->route('propertyType') ?: null;
        return PropertyType::rules($data?->id);
    }
}
