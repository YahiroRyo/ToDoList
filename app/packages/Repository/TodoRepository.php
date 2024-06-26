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
        $todoModel = TodoModel::create([
            'contents' => $todo->getContents()->value(),
        ]);

        return Todo::create(
            Id::create($todoModel->id),
            $todo->getContents(),
        );
    }

    public function edit(Todo $todo): Todo
    {
        $todoModel = TodoModel::find($todo->getId()->value());

        $todoModel->update($todo->toArray());

        return $todo;
    }

    public function delete(Todo $todo): Todo
    {
        TodoModel::find($todo->getId()->value())->delete();

        return $todo;
    }
}
