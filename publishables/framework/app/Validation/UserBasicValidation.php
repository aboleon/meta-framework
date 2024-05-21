<?php

namespace App\Validation;


use Aboleon\MetaFramework\Services\Validation\ValidationAbstract;

class UserBasicValidation extends ValidationAbstract
{

    private string $prefix = '';
    private ?int $against_user_id = null;

    public function setPrefix(string $prefix): static
    {
        $this->prefix = $prefix . '.';
        return $this;
    }

    public function setUserId(int $user_id): static
    {
        $this->against_user_id = $user_id;
        return $this;
    }

    /**
     * @return array<string, array<int,string>>
     */
    public function rules(): array
    {
        return [
            $this->prefix . 'first_name' => ['required', 'string', 'max:255'],
            $this->prefix . 'last_name' => ['nullable', 'string', 'max:255'],
            $this->prefix . 'email' => ['required', 'email', 'unique:users,email' . ($this->against_user_id ? ',' . $this->against_user_id : '')],
        ];
    }

    /**
     * @return array<mixed>
     */
    public function messages(): array
    {
        return [
            $this->prefix . 'first_name.required' => __('validation.required', ['attribute' => strval(__('aboleon-framework-account.first_name'))]),
            $this->prefix . 'first_name.string' => __('validation.string', ['attribute' => strval(__('aboleon-framework-account.first_name'))]),
            $this->prefix . 'last_name.required' => __('validation.required', ['attribute' => strval(__('aboleon-framework-account.last_name'))]),
            $this->prefix . 'last_name.string' => __('validation.string', ['attribute' => strval(__('aboleon-framework-account.first_name'))]),
            $this->prefix . 'email.required' => __('validation.required', ['attribute' => strval(__('aboleon-framework.email_address'))]),
            $this->prefix . 'email.email' => __('validation.email', ['attribute' => strval(__('aboleon-framework.email_address'))]),
            $this->prefix . 'email.unique' => __('validation.unique', ['attribute' => strval(__('aboleon-framework.email_address'))]),
        ];
    }
}
