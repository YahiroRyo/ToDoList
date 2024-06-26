<?php

namespace Packages\Service;

use Packages\Domain\Entity\Todo;
use Packages\Repository\TodoRepositoryInterface;

class TodoService
{
    private TodoRepositoryInterface $todoRepository;

    public function __construct(TodoRepositoryInterface $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function getTodos()
    {
        return $this->todoRepository->getTodos();
    }

    public function create(Todo $todo)
    {
        return $this->todoRepository->create($todo);
    }

    public function edit(Todo $todo)
    {
        return $this->todoRepository->edit($todo);
    }

    public function delete(Todo $todo)
    {
        return $this->todoRepository->delete($todo);
    }
}
