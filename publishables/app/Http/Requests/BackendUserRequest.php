<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Validation\UserBasicValidation;
use Illuminate\Foundation\Http\FormRequest;
use Aboleon\MetaFramework\Services\Passwords\PasswordValidationSet;

class BackendUserRequest extends FormRequest
{
    /**
     * @var array<array<string>>
     */
    private array $password_validation;

    /**
     * @var array<array<string,mixed>>
     */
    private array $profile_validation;

    private UserBasicValidation $user_validation;

    public function __construct(public ?User $user = null)
    {
        parent::__construct();

        $this->user_validation = (new UserBasicValidation)->setPrefix('user');

        if ($this->user instanceof User && $this->user->id) {
            $this->user_validation->setUserId($this->user->id);
        }

        $this->password_validation = (new PasswordValidationSet(request()))->logic();

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
        return array_merge(
            $this->user_validation->rules(),
            $this->password_validation['rules']
        );

    }

    /**
     * @return array<string,mixed>
     */
    public function messages(): array
    {
        return array_merge(
            $this->user_validation->messages(),
            $this->password_validation['messages']
        );
    }
}
