<?php

namespace App\Http\Controllers;

use App\Http\Requests\Todo\CreateTodoRequest;
use App\Http\Requests\Todo\DeleteTodoRequest;
use App\Http\Requests\Todo\EditTodoRequest;
use Packages\Service\TodoService;

class TodoController extends Controller
{
    private TodoService $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    public function index()
    {
        $todos = $this->todoService->getTodos();

        return view('index', ['todos' => $todos]);
    }

    public function create(CreateTodoRequest $request)
    {
        $todo = $request->to();

        $createdTodo = $this->todoService->create($todo);

        return $createdTodo->toArray();
    }

    public function edit(EditTodoRequest $request)
    {
        $todo = $request->to();

        $editedTodo = $this->todoService->edit($todo);

        return $editedTodo->toArray();
    }

    public function delete(DeleteTodoRequest $request)
    {
        $todo = $request->to();

        $deletedTodo = $this->todoService->delete($todo);

        return $deletedTodo->toArray();
    }
}
