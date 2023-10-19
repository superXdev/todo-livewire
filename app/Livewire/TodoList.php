<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Throwable;

class TodoList extends Component
{
    use WithPagination;

    #[Rule('required|string|max:120')]
    public $title;

    public $keyword;

    public $editingID;

    #[Rule('required|string|max:120')]
    public $editingTitle;

    public function create()
    {
        try {
            $validated = $this->validateOnly('title');
            
            Todo::create($validated);

            $this->reset('title');

            session()->flash('success', 'Todo was saved!');
        } catch(Throwable $e) {
            session()->flash('error', 'Failed to create');
            return;
        }
    }

    public function delete($id)
    {
        try {
            Todo::findOrfail($id)->delete();
        } catch(Throwable $e) {
            session()->flash('error', 'Failed to delete');
            return;
        }
        
    }

    public function toggle($id)
    {
        try {
            $todo = Todo::findOrfail($id);
            $todo->completed = !$todo->completed;
            $todo->save();
        } catch(Throwable $e) {
            session()->flash('error', 'Failed to check');
            return;
        }
        
    }

    public function edit($id)
    {
        try {
            $this->editingID = $id;
            $this->editingTitle = Todo::findOrfail($id)->title;
        } catch(Throwable $e) {
            session()->flash('error', 'Failed to fetch');
            return;
        }
        
    }

    public function cancelEdit()
    {
        $this->reset(['editingTitle', 'editingID']);
    }

    public function update()
    {
        try {
            $this->validateOnly('editingTitle');

            Todo::findOrfail($this->editingID)->update(['title' => $this->editingTitle]);

            $this->cancelEdit();
        } catch(Throwable $e) {
            session()->flash('error', 'Failed to update');
            return;
        }
        
    }

    public function render()
    {
        return view('livewire.todo-list', [
            'todos' => Todo::latest()->where('title', 'like', "%{$this->keyword}%")->paginate(5)
        ]);
    }
}
