<div>
    @if($assigned)
    <button type="button" wire:click="detach" class="text-amber-500">{{__('Detach')}}</button>
    @else
    <button type="button" wire:click="attach" class="text-yellow-400">{{__('Attach')}}</button>
    @endif
</div>