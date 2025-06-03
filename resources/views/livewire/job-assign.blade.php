<div>
    @if($assigned)
    <button type="button" wire:click="detach" class="text-amber-500">Detach</button>
    @else
    <button type="button" wire:click="attach" class="text-yellow-400">Attach</button>
    @endif
</div>