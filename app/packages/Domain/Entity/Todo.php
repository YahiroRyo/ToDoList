<?php

namespace Packages\Domain\Entity;

use Packages\Domain\ValueObjects\Todo\Contents;
use Packages\Domain\ValueObjects\Todo\Id;

class Todo
{
    private Id $id;
    private Contents $contents;

    // privateなコンストラクタを定義
    private function __construct(Id $id, Contents $contents)
    {
        $this->id = $id;
        $this->contents = $contents;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getContents()
    {
        return $this->contents;
    }

    public function toArray()
    {
        return [
            'id'       => $this->id->value(),
            'contents' => $this->contents->value(),
        ];
    }

    // エンティティを作成するメソッド
    public static function create(Id $id, Contents $contents)
    {
        return new Todo($id, $contents);
    }
}
