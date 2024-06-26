<?php

namespace Packages\Domain\ValueObjects\Todo;

use Illuminate\Support\Facades\Validator;

class Contents
{
    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }

    public static function unsafeCreate()
    {
        return new Contents('');
    }

    public static function create(string $value)
    {
        Validator::make(
            ['contents' => $value],
            ['contents' => ['required', 'max:2048']],
            ['contents.required' => '内容は必須項目です。', 'contents.max' => '内容の文字数は2049文字未満でお願いします。']
        )->validate();

        return new Contents($value);
    }
}
