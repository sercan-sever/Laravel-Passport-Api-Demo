<?php

namespace App\Http\Requests\Api\V1;

use App\Enums\ImageTypeEnum;
use App\Enums\SizeEnum;
use Illuminate\Foundation\Http\FormRequest;

class ProductImageUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'productID'       => 'required|numeric|min:1',
            'image'           => 'required|image|mimes:' . ImageTypeEnum::ImageMime->value . '|max:' . SizeEnum::Size5->value,
        ];
    }


    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function attributes(): array
    {
        return [
            'productID'       => 'Ürün ID',
            'image'           => 'Ürün Görsel',
        ];
    }
}
