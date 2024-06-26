<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TODOリスト</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">TODOリスト</h1>

        <form id="todo-form" class="mb-4">
            <div class="input-group">
                <input type="text" id="todo-input" class="form-control" placeholder="新しいTODOを入力" required>
                <button type="submit" class="btn btn-primary">追加</button>
            </div>
        </form>

        <ul id="todo-list" class="list-group">
            @foreach ($todos as $todo)
                <li class="list-group-item d-flex justify-content-between align-items-center"
                    data-id="{{ $todo->getId()->value() }}">
                    <span class="todo-content">{{ $todo->getContents()->value() }}</span>
                    <div>
                        <button class="btn btn-sm btn-outline-primary edit-todo">編集</button>
                        <button class="btn btn-sm btn-outline-danger delete-todo">削除</button>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- 編集モーダル -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">TODOの編集</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-form">
                        <div class="mb-3">
                            <label for="edit-todo-input" class="form-label">TODO内容</label>
                            <input type="text" class="form-control" id="edit-todo-input" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                    <button type="button" class="btn btn-primary" id="confirmEdit">保存</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">削除の確認</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    このTODOを削除してもよろしいですか？
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">削除</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const todoForm = document.getElementById('todo-form');
            const todoInput = document.getElementById('todo-input');
            const todoList = document.getElementById('todo-list');
            const deleteConfirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
            const editForm = document.getElementById('edit-form');
            const editTodoInput = document.getElementById('edit-todo-input');
            let todoToDelete = null;
            let todoToEdit = null;

            function animateCSS(element, animation, prefix = 'animate__') {
                return new Promise((resolve, reject) => {
                    const animationName = `${prefix}${animation}`;
                    element.classList.add(`${prefix}animated`, animationName);

                    function handleAnimationEnd(event) {
                        event.stopPropagation();
                        element.classList.remove(`${prefix}animated`, animationName);
                        resolve('Animation ended');
                    }

                    element.addEventListener('animationend', handleAnimationEnd, {
                        once: true
                    });
                });
            }


            // TODO追加
            todoForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const contents = todoInput.value;
                try {
                    const response = await fetch("{{ route('todos.create') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            contents: contents
                        })
                    });
                    const data = await response.json();
                    const newTodo = document.createElement('li');
                    newTodo.className =
                        'list-group-item d-flex justify-content-between align-items-center';
                    newTodo.dataset.id = data.id;
                    newTodo.innerHTML = `
                        <span class="todo-content">${contents}</span>
                        <div>
                            <button class="btn btn-sm btn-outline-primary edit-todo">編集</button>
                            <button class="btn btn-sm btn-outline-danger delete-todo">削除</button>
                        </div>
                    `;
                    todoList.appendChild(newTodo);
                    await animateCSS(newTodo, 'bounceIn');
                    todoInput.value = '';
                    await animateCSS(todoInput, 'rubberBand');
                } catch (error) {
                    console.error('Error:', error);
                }
            });

            // TODO編集（モーダル表示）
            todoList.addEventListener('click', async (e) => {
                if (e.target.classList.contains('edit-todo')) {
                    todoToEdit = e.target.closest('li');
                    const content = todoToEdit.querySelector('.todo-content').textContent;
                    editTodoInput.value = content;
                    editModal.show();
                }
            });

            // 編集確認ボタンクリック時の処理
            document.getElementById('confirmEdit').addEventListener('click', async () => {
                if (todoToEdit) {
                    const id = todoToEdit.dataset.id;
                    const newContent = editTodoInput.value;
                    try {
                        await fetch("{{ route('todos.edit') }}", {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                id: id,
                                contents: newContent
                            })
                        });
                        editModal.hide();

                        const contentElement = todoToEdit.querySelector('.todo-content');
                        await animateCSS(contentElement, 'flipInX');
                        todoToEdit.querySelector('.todo-content').textContent = newContent;
                        todoToEdit = null;
                    } catch (error) {
                        console.error('Error:', error);
                    }
                }
            });

            // 削除ボタンクリック時の処理
            todoList.addEventListener('click', async (e) => {
                if (e.target.classList.contains('delete-todo')) {
                    todoToDelete = e.target.closest('li');
                    deleteConfirmModal.show();
                }
            });

            // 削除確認モーダルの削除ボタンクリック時の処理
            document.getElementById('confirmDelete').addEventListener('click', async () => {
                if (todoToDelete) {
                    const id = todoToDelete.dataset.id;
                    try {
                        await fetch("{{ route('todos.delete') }}" + `?id=${id}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            }
                        });
                        deleteConfirmModal.hide();

                        await animateCSS(todoToDelete, 'zoomOutLeft');
                        todoToDelete.remove();
                        todoToDelete = null;
                    } catch (error) {
                        console.error('Error:', error);
                    }
                }
            });

            // ページ読み込み時のアニメーション
            document.querySelector('h1').classList.add('animate__animated', 'animate__bounceInDown');
            todoList.querySelectorAll('li').forEach((li, index) => {
                setTimeout(() => {
                    li.classList.add('animate__animated', 'animate__fadeInRight');
                }, index * 100);
            });
        });
    </script>
</body>

</html>
