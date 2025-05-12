<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class GetUserTransactionsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page' => 'nullable|integer|min:1',
            'limit' => 'nullable|integer|min:1|max:50',
            'paginate' => 'nullable|boolean',
            'sort' => 'nullable|string|in:asc,desc',
            'sortField' => 'nullable|string|in:created_at,amount,type',
        ];
    }
} 