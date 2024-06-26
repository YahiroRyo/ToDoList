<?php

namespace Packages\Repository;

use App\Models\Todo as TodoModel;
use Illuminate\Support\Collection;
use Packages\Domain\Entity\Todo;
use Packages\Domain\ValueObjects\Todo\Contents;
use Packages\Domain\ValueObjects\Todo\Id;

class TodoRepository implements TodoRepositoryInterface
{
    public function getTodos(): Collection
    {
        return TodoModel::all()->map(function($todoModel) {
            return Todo::create(
                Id::create($todoModel->id),
                Contents::create($todoModel->contents)
            );
        });
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
