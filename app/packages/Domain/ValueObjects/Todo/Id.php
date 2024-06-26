<?php

namespace Packages\Domain\ValueObjects\Todo;

use Illuminate\Support\Facades\Validator;

class Id
{
    private int $value;

    private function __construct(int $value)
    {
        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }

    public static function unsafeCreate()
    {
        return new Id(0);
    }

    public static function create(int $value)
    {
        Validator::make(
            ['id' => $value],
            ['id' => ['required', 'min:1']],
            ['id.required' => 'IDは必須項目です。', 'id.min' => 'IDの1以上でお願いします。']
        )->validate();

        return new Id($value);
    }
}
