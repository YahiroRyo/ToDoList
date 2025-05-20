<?php

namespace App\Http\Controllers;

use App\Http\Requests\Todo\CreateTodoRequest;
use App\Http\Requests\Todo\DeleteTodoRequest;
use App\Http\Requests\Todo\EditTodoRequest;
use Packages\Service\GetTodosService;
use Packages\Service\CreateTodoService;
use Packages\Service\EditTodoService;
use Packages\Service\DeleteTodoService;

class TodoController extends Controller
{
    private GetTodosService $getTodosService;
    private CreateTodoService $createTodoService;
    private EditTodoService $editTodoService;
    private DeleteTodoService $deleteTodoService;

    public function __construct(
        GetTodosService $getTodosService,
        CreateTodoService $createTodoService,
        EditTodoService $editTodoService,
        DeleteTodoService $deleteTodoService
    ) {
        $this->getTodosService = $getTodosService;
        $this->createTodoService = $createTodoService;
        $this->editTodoService = $editTodoService;
        $this->deleteTodoService = $deleteTodoService;
    }

    public function index()
    {
        $todos = $this->getTodosService->execute();

        return view('index', ['todos' => $todos]);
    }

    public function create(CreateTodoRequest $request)
    {
        $todo = $request->toDomain();

        $createdTodo = $this->createTodoService->execute($todo);

        return $createdTodo->toArray();
    }

    public function edit(EditTodoRequest $request)
    {
        $todo = $request->toDomain();

        $editedTodo = $this->editTodoService->execute($todo);

        return $editedTodo->toArray();
    }

    public function delete(DeleteTodoRequest $request)
    {
        $todo = $request->toDomain();

        $deletedTodo = $this->deleteTodoService->execute($todo);

        return $deletedTodo->toArray();
    }
}
