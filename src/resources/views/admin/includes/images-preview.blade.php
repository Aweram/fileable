<div class="row">
    @foreach($forUpload as $key => $item)
        <div class="col w-1/3">
            <img src="{{ $item['image']->temporaryUrl() }}" alt="preview" class="w-28 h-28 object-cover rounded">
            <input class="form-control" type="text" wire:model="forUpload.{{ $key }}.name" @if ($uploadProcess) disabled @endif>
            <button type="button" class="btn btn-outline-danger" wire:click.prevent="deleteImageItem({{ $key }})" @if ($uploadProcess) disabled @endif>Delete</button>
        </div>
    @endforeach
    @if (count($forUpload))
        <div class="col w-full">
            <button type="button" class="btn" wire:click="startUploadImages" @if ($uploadProcess) disabled @endif wire:loading.attr="disabled">Load</button>
        </div>
    @endif
</div>
