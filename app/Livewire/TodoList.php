<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;

class TodoList extends Component
{
    use WithPagination;

    #[Rule('required|string|max:120')]
    public $title;

    public $keyword;

    public function create()
    {
        $validated = $this->validateOnly('title');
        
        Todo::create($validated);

        $this->reset('title');

        session()->flash('success', 'Todo was saved!');
    }

    public function render()
    {
        return view('livewire.todo-list', [
            'todos' => Todo::latest()->where('title', 'like', "%{$this->keyword}%")->paginate(5)
        ]);
    }
}
