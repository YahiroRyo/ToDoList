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

    // タスク新規作成
    public function create(CreateTodoRequest $request)
    {
        // リクエストされた内容をエンティティに変換
        $todo = $request->toDomain();

        // エンティティを保存
        $createdTodo = $this->createTodoService->execute($todo);

        // 保存したエンティティを配列に変換して返す
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
