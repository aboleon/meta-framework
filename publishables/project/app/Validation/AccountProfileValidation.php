<?php

namespace App\Validation;

use MetaFramework\Services\Validation\ValidationAbstract;
use App\Enum\Civility;
use App\Models\Account;
use Illuminate\Validation\Rules\Enum;

class AccountProfileValidation extends ValidationAbstract
{
    public function __construct(public ?Account $account = null)
    {

    }

    /**
     * @return array<string, array<int, \Illuminate\Validation\Rules\Enum|string>|string>>
     */
    public function rules(): array
    {
        return [
            'profile.birth' => 'nullable|date_format:d/m/Y',
            'profile.civ' => [
                'nullable',
                new Enum(Civility::class),
            ],
            'profile.blacklisted' => 'boolean',
            'profile.blacklist_comment' => 'nullable|string',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        return [
            'profile.birth.date' => __('validation.date', ['attribute' => strval(__('forms.fields.birth'))]),
            'profile.account_type.required' => __('validation.required', ['attribute' => "Type de client"])
            ];
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function logic(): array
    {
        return [
            'rules' => $this->rules(),
            'messages' => $this->messages(),
        ];
    }
}
