<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountPhoneRequest extends FormRequest
{

    private string $prefix = '';

    public function __construct()
    {
        parent::__construct();
        $this->setPrefix('phone');

    }


    public function setPrefix(string $prefix): static
    {
        $this->prefix = $prefix . '.';
        return $this;
    }

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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            $this->prefix . 'name' => ['nullable', 'string'],
            $this->prefix . 'default' => ['nullable', 'boolean'],
            $this->prefix . 'country_code' => 'required_with:' . $this->prefix . 'number',
            $this->prefix . 'phone' => 'phone:INTERNATIONAL,' . $this->prefix . 'country_code',
        ];
    }

    /**
     * @return array<string,mixed>
     */
    public function messages(): array
    {
        return [
            $this->prefix . 'name.string' => __('validation.string', ['attribute' => strval(__('ui.title'))]),
            $this->prefix . 'default.boolean' => __('validation.boolean', ['attribute' => "Le choix de définir ce numéro comme principal"]),
            $this->prefix . 'phone.phone' => __('validation.phone', ['attribute' => strval(__('account.phone'))]),
            $this->prefix . 'country_code.required_with' => __('validation.required_with', ['attribute' => strval(__('ui.geo.country_code')), 'values' => strval(__('account.phone'))]),
        ];

    }
}
