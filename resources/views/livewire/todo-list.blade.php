<div>
    @include('livewire.includes.create-box')

    @include('livewire.includes.search')

    <div id="todos-list">
        @foreach($todos as $todo)
            @include('livewire.includes.todo-card', compact('todo'))
        @endforeach

        <div class="my-2">
            {{ $todos->links() }}
        </div>
    </div>
</div>
