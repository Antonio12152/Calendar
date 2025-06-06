<div>
    <div>
        <div class="query">
            <input
                wire:model.live.debounce.300ms="search"
                type="text"
                placeholder="{{__('Search users')}}..."
                class="focus:ring-blue-500 w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2" />
        </div>
    </div>
    @foreach($users as $user)
    <div class="">
        <a href="{{ route('users.show', ['user_id' => $user->id]) }}">
            <br />
            {{ $user->name }}
            <br />
            {{ $user->admin }}
        </a>
    </div>
    @endforeach
</div>