<?php

namespace Packages\Service;

use Packages\Domain\Entity\Todo;
use Packages\Repository\TodoRepositoryInterface;

class CreateTodoService
{
    private TodoRepositoryInterface $todoRepository;

    public function __construct(TodoRepositoryInterface $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function execute(Todo $todo)
    {
        return $this->todoRepository->create($todo);
    }
}
