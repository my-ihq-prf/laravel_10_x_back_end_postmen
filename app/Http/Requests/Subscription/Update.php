<?php

namespace App\Http\Requests\Subscription;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;


class Update extends FormRequest
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
        if (is_null($user)) {
            return false;
        }
        if ($user->isAdmin) {
            return true;
        }
        if ($this->input('amount', 0)) {
            return true;
        }
        if (!is_null($this->input('is_active', null))) {
            return true;
        }
        return false;
    }


    /**
     * Show the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'is_active' => 'sometimes|required|boolean',
            'name' => 'sometimes|required|string|unique:subscriptions|between:3,128',
            'price' => 'sometimes|required|numeric|between:1340,10000',
            'max_articles' => 'sometimes|required|numeric|between:10,1000',
            'amount' => 'sometimes|required|numeric|min:300',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $inputs = [];

        $isActive = $this->input('is_active', null);
        if (!is_null($isActive)) {
            $inputs['is_active'] = $isActive;
        }

        $name = $this->input('name', null);
        if (!is_null($name)) {
            $inputs['name'] = $name;
        }

        $price = $this->input('price', null);
        if (is_numeric($price)) {
            $inputs['price'] = (int)$price;
        }

        $maxArticles = $this->input('max_articles', null);
        if (is_numeric($maxArticles)) {
            $inputs['max_articles'] = (int)$maxArticles;
        }

        $amount = $this->input('amount', null);
        if (is_numeric($amount)) {
            $inputs['amount'] = (double)$amount;
        }

        $this->replace($inputs);
    }
}
