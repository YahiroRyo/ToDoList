<?php

namespace Packages\Repository;

use Illuminate\Support\Collection;
use Packages\Domain\Entity\Todo;

interface TodoRepositoryInterface
{
    public function getTodos(): Collection;

    public function create(Todo $todo): Todo;

    public function edit(Todo $todo): Todo;

    public function delete(Todo $todo): Todo;
}
