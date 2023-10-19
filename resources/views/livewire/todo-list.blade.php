<div>
    @include('livewire.includes.create-box')

    @include('livewire.includes.search')

    @if(session()->has('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-3" role="alert">
      <p class="font-bold">Error!</p>
      <p>{{ session()->get('error') }}</p>
    </div>
    @endif

    <div id="todos-list">
        @foreach($todos as $todo)
            @include('livewire.includes.todo-card', compact('todo'))
        @endforeach

        <div class="my-2">
            {{ $todos->links() }}
        </div>
    </div>
</div>
