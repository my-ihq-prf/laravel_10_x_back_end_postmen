<?php

namespace App\Http\Requests\Subscription;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;


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
        return !is_null($user) && $user->isAdmin;
    }

    /**
     * Show the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:subscriptions|between:3,128',
            'price' => 'required|integer|between:1340,10000',
            'max_articles' => 'required|integer|between:10,1000'
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $price = $this->input('price', 0);
        $maxArticles = $this->input('max_articles', 0);

        $this->replace([
            'name' => $this->input('name', null),
            'price' => is_numeric($price) ? (int)$price : 0,
            'max_articles' => is_numeric($maxArticles) ? (int)$maxArticles : 0,
        ]);
    }
}
