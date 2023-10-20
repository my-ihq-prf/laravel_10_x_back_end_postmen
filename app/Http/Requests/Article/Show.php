<?php

namespace App\Http\Requests\Article;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class Show extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !is_null(auth()?->user());
    }

    /**
     * Show the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'filter' => [
                'array:with,q',
                function ($attribute, $value, $fail) {
                    $flt = $value;
                    if (
                        !isset($flt['with'])
                    ) {
                        $fail('The ' . $attribute . '.filter.with is not exist.');
                    }
                    if (
                        !is_array($value['with'])
                    ) {
                        $fail('The ' . $attribute . '.filter.with is not array.');
                    }
                    if (count(array_diff($flt['with'], ['id', 'title', 'body', 'publish_at', 'author']))) {
                        $fail('The ' . $attribute . '.filter.with has some unsupported keys: [' . implode(',', $flt['with']) . ']');
                    }
                    if (
                        !isset($flt['q'])
                    ) {
                        $fail('The ' . $attribute . '.filter.q is missing.');
                    }
                    if (strlen($flt['q']) < 3) {
                        $fail('The ' . $attribute . '.filter.q length less than 3!');
                    }
                },
            ],
        ];
    }
}
