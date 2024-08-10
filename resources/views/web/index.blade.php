@extends('layouts.app')
@section('content')
    <section class="position-relative overflow-hidden">
        <div class="container">
            <div class="row main-comp align-items-center justify-content-center">
                <div class="col-lg-6 mb-3 mb-lg-5">
                    <div class="card">
                        <div class="card-header p-4 text-center">
                            <h4 class="mb-0 text-white">To Do List Demo</h4>
                        </div>
                        <div class="card-body p-0">
                            <form method="post" action="{{ route('store') }}">
                                @csrf
                                <div class="list-group list-group-flush">
                                    @foreach($todos as $todo)
                                        <div class="list-group-item py-0 px-4" id="todo-item-{{ $todo->id }}">
                                            <div class="form-check mb-0 d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <input
                                                        class="form-check-input rounded-circle p-2"
                                                        type="checkbox"
                                                        id="checkbox-todo-{{ $todo->id }}"
                                                        {{ $todo->completed ? 'checked' : '' }}
                                                        data-todo-id="{{ $todo->id }}">

                                                    <label
                                                        class="form-check-label mb-0 p-3 {{ $todo->completed ? 'text-decoration-line-through opacity-5' : '' }}"
                                                        for="checkbox-todo-{{ $todo->id }}">
                                                        {{ $todo->title }}
                                                    </label>
                                                </div>
                                                <button type="button" class="btn btn-danger px-4 py-1 delete-btn"
                                                        data-todo-id="{{ $todo->id }}">
                                                    Delete
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="p-4">
                                    <div class="row align-items-center justify-content-center">
                                        <div class="col-md-8">
                                            <input
                                                type="text"
                                                name="title"
                                                class="form-control bg-transparent ps-4 shadow-none py-3"
                                                placeholder="Add new todo"
                                                required>
                                        </div>
                                        <div class="col-md-4">
                                            <button class="btn btn-sm btn-success p-3 w-100">
                                                <span class="material-symbols-rounded align-middle">
                                                    Add
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script type="module">
            import { patchTodoStatus, deleteTodo } from '/js/api.js';

            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                    checkbox.addEventListener('change', async function () {
                        const todoId = this.dataset.todoId;
                        const listItem = document.getElementById(`todo-item-${todoId}`);
                        const isCompleted = this.checked;
                        await patchTodoStatus(todoId, isCompleted);
                        if (isCompleted) {
                            listItem.classList.add('list-group-item-success');
                            listItem.querySelector('label').classList.add('text-decoration-line-through', 'opacity-5');
                        } else {
                            listItem.classList.remove('list-group-item-success');
                            listItem.querySelector('label').classList.remove('text-decoration-line-through', 'opacity-5');
                        }
                    });
                });

                document.querySelectorAll('.delete-btn').forEach(button => {
                    button.addEventListener('click', async function () {
                        const todoId = this.dataset.todoId;
                        const listItem = document.getElementById(`todo-item-${todoId}`);

                        const result = await Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to recover this todo!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        });
                        if (result.isConfirmed) {
                            await deleteTodo(todoId);
                            Swal.fire(
                                'Deleted!',
                                'Your todo has been deleted.',
                                'success'
                            ).then(() => {
                                listItem.remove();
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
