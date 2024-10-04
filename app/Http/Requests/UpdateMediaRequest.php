<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMediaRequest extends FormRequest
{
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file' => 'sometimes|required|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi,wmv|max:20480',
            'event_id' => 'sometimes|required|exists:events,id',
            'type' => 'sometimes|required|in:photo,video',
        ];
    }
}
