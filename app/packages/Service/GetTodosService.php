<?php

namespace Packages\Service;

use Packages\Repository\TodoRepositoryInterface;

class GetTodosService
{
    private TodoRepositoryInterface $todoRepository;

    public function __construct(TodoRepositoryInterface $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function execute()
    {
        return $this->todoRepository->getTodos();
    }
} 