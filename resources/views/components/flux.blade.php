<div class="mb-3">
    @if($status == config('bricks-flux.status.draft'))
        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
            <input type="radio" class="btn-check" name="status" id="status_draft" value="draft" autocomplete="off" checked>
            <label class="btn btn-outline-warning" for="status_draft">{{ __('bricks-flux::flux.status.draft') }}</label>

            <input type="radio" class="btn-check" name="status" id="status_publish" value="published" autocomplete="off">
            <label class="btn btn-outline-success" for="status_publish">{{ __('bricks-flux::flux.status.published') }}</label>
        </div>
    @else
        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
            <input type="radio" class="btn-check" name="status" id="status_publish" value="published" autocomplete="off" @if($status === config('bricks-flux.status.published')) checked @endif>
            <label class="btn btn-outline-success" for="status_publish">{{ __('bricks-flux::flux.status.published') }}</label>

            <input type="radio" class="btn-check" name="status" id="status_unpublish" value="unpublished" autocomplete="off" @if($status === config('bricks-flux.status.unpublished')) checked @endif>
            <label class="btn btn-outline-danger" for="status_unpublish">{{ __('bricks-flux::flux.status.unpublished') }}</label>
        </div>
    @endif
</div>
