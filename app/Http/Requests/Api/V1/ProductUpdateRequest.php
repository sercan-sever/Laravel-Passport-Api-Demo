<?php

namespace App\Http\Requests\Api\V1;

use App\Enums\ImageTypeEnum;
use App\Enums\SizeEnum;
use App\Enums\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
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
            'name'            => 'required|string|min:1|max:255|unique:products,name,' . $this->productID,
            'short_statement' => 'nullable|string|min:1|max:300',
            'statement'       => 'nullable|string|min:1',
            'price'           => 'required|numeric|decimal:2|between:1,99999999.99|not_in:0',
            'status'          => 'required|' . Rule::in(StatusEnum::values()),
            'image'           => 'nullable|image|mimes:' . ImageTypeEnum::ImageMime->value . '|max:' . SizeEnum::Size5->value,
        ];
    }


    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function attributes(): array
    {
        return [
            'productID'       => 'Ürün ID',
            'name'            => 'Ürün Adı',
            'short_statement' => 'Kısa Açıklama',
            'statement'       => 'Açıklama',
            'price'           => 'Fiyat',
            'status'          => 'Durum',
            'image'           => 'Ürün Görsel',
        ];
    }
}
