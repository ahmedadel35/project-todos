<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class TodoList extends Component
{
    protected $listeners = [
        "todo:saved" => "appendTodo",
        'todo:updated' => 'updateTodoList',
    ];

    public Collection $todos;
    public Category $category;

    public function mount(Category $category): void
    {
        $this->category = $category;
        $this->todos = Todo::where("user_id", auth()->id())
            ->where("category_id", $category->id)
            ->latest()
            ->get();
    }

    public function appendTodo(Todo $todo)
    {
        $this->todos->prepend($todo);
    }

    public function remove(int $id): void
    {
        Todo::find($id)->delete();

        $this->todos = $this->todos->filter(
            fn(Todo $todo) => $todo->id !== $id
        );
    }

    public function edit(int $id): void
    {
        $todo = $this->todos->find($id);

        $this->emit("editTodo", $todo);
    }

    public function updateTodoList(int $id, string $body)
    {
        $this->todos->each(function (Todo $todo) use ($id, $body) {
            if ($todo->id === $id) {
                $todo->body = $body;
            }
        });
    }

    public function render()
    {
        return view("livewire.todo-list");
    }
}
