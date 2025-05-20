<?php

namespace Packages\Service;

use Packages\Domain\Entity\Todo;
use Packages\Repository\TodoRepositoryInterface;

class CreateTodoService
{
    private TodoRepositoryInterface $todoRepository;

    // TodoRepositoryをDI
    public function __construct(TodoRepositoryInterface $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    // タスク新規作成
    public function execute(Todo $todo)
    {
        // TodoRepositoryのcreateメソッドを呼び出す
        return $this->todoRepository->create($todo);
    }
}
