<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        switch ($this->method()) {
            case 'POST':

                return [
                    'courses' => ['required', 'array'],
                    'code' => [
                        'required',
                        'min:6',
                        'max:20',
                        Rule::unique('coupons')->where(function ($query) {
                            return $query->where('user_id', auth()->id());
                        }),
                    ],
                    'description' => 'required|min:10',
                    'discount_type' => [
                        'required',
                        Rule::in(Coupon::PERCENT, Coupon::PRICE),
                    ],
                    'discount' => 'required',
                ];

            case 'PUT':
                return [
                    'courses' => ['required', 'array'],
                    'code' => [
                        'required',
                        'min:6',
                        'max:20',
                        Rule::unique('coupons')->where(function ($query) {
                            return $query
                                ->where('user_id', auth()->id())
                                ->where('id', '!=', $this->route('coupon')->id);
                        }),
                    ],
                    'description' => 'required|min:10',
                    'discount_type' => [
                        'required',
                        Rule::in(Coupon::PERCENT, Coupon::PRICE),
                    ],
                    'discount' => 'required',
                ];

            default:
                return [];

        }
    }
}
