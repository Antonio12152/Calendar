<div>
    @if($assigned)
    <a href="{{ route('jobs.detach', ['job_id' => $job_id]) }}" class="text-amber-500">Detach</a>
    @else
    <a href="{{ route('jobs.attach', ['job_id' => $job_id]) }}" class="text-yellow-400">Attach</a>
    @endif
</div>