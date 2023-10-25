<div>
    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
        <button type="button" class="btn btn-sm
        @switch($flowable->status)
            @case(config('bricks-flux.status.draft'))
                    btn-warning
                @break
            @case(config('bricks-flux.status.published'))
                    btn-success
                @break
            @case(config('bricks-flux.status.unpublished'))
                    btn-danger
                @break
        @endswitch
        ">{{ $flowable->trans_status }}</button>
    @if($flowable->status == config('bricks-flux.status.draft') || $flowable->status == config('bricks-flux.status.unpublished'))
        <button type="button" class="btn btn-sm btn-outline-info" wire:click="toggle('{{ config('bricks-flux.status.published') }}')">{{ __('bricks-flux::flux.status.published') }}</button>
    @else
        <button type="button" class="btn btn-sm btn-outline-info" wire:click="toggle('{{ config('bricks-flux.status.unpublished') }}')">{{ __('bricks-flux::flux.status.unpublished') }}</button>
    @endif
    </div>
</div>

