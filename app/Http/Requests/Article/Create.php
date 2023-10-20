<?php

namespace App\Http\Requests\Article;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class Create extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /**
         * @var User $user
         */
        $user = auth()?->user();
        return !is_null($user) && !$user->isAdmin;
    }

    /**
     * Show the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'between:3,150',
                Rule::unique('articles')->where(function (Builder $query) {
                    $title = $this->input('title', 0);
                    $userId = $this->user()->id;

                    $query
                        ->where('user_id', $userId)
                        ->where('title', $title);
                    return $query;
                }),
            ],
            'body' => 'required|string|between:10,2000'
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->replace($this->data);
    }
}
