<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Component;
use Livewire\Attributes\Rule;

class TodoList extends Component
{
    #[Rule('required|string|max:120')]
    public $title;

    public function create()
    {
        $validated = $this->validateOnly('title');
        
        Todo::create($validated);

        $this->reset('title');

        session()->flash('success', 'Todo was saved!');
    }

    public function render()
    {
        return view('livewire.todo-list');
    }
}
