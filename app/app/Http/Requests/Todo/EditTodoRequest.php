<?php

namespace App\Http\Requests\Todo;

use Illuminate\Foundation\Http\FormRequest;
use Packages\Domain\Entity\Todo;
use Packages\Domain\ValueObjects\Todo\Contents;
use Packages\Domain\ValueObjects\Todo\Id;

class EditTodoRequest extends FormRequest
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
            //
        ];
    }

    public function to()
    {
        return Todo::create(
            Id::create(intval($this->id)),
            Contents::create($this->contents)
        );
    }
}
