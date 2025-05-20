<?php

namespace Packages\Repository;

use App\Models\Todo as TodoModel;
use Illuminate\Support\Collection;
use Packages\Domain\Entity\Todo;
use Packages\Domain\ValueObjects\Todo\Contents;
use Packages\Domain\ValueObjects\Todo\Id;

class DummyTodoRepository implements TodoRepositoryInterface
{
    public function getTodos(): Collection
    {
        return collect([Todo::create(Id::create(1), Contents::create("内容"))]);
    }

    public function create(Todo $todo): Todo
    {
        return Todo::create(Id::create(1), $todo->getContents());
    }

    public function edit(Todo $todo): Todo
    {
        return $todo;
    }

    public function delete(Todo $todo): Todo
    {
        return $todo;
    }
}
