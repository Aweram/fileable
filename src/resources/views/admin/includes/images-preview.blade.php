<div class="row">
    @foreach($forUpload as $key => $item)
        @php
            $imgError = $errors->has("image") && $key === 0;
            $nameError = $errors->has("name") && $key === 0;
        @endphp
        <div class="col w-1/3">
            @if ($item["preview"])
                <img src="{{ $item['preview'] }}" alt="preview"
                     class="w-28 h-28 object-cover rounded border border-transparent {{ $imgError ? "border-danger" : "" }}">
            @else
                <div>No preview</div>
            @endif
            @if ($imgError) <x-tt::form.error name="image" /> @endif

            <input class="form-control {{ $nameError ? "border-danger" : "" }}"
                   type="text" aria-label="Name"
                   wire:model="forUpload.{{ $key }}.name"
                   @if ($uploadProcess) disabled @endif>
            @if ($nameError) <x-tt::form.error name="name" />@endif

            <button type="button" class="btn btn-outline-danger"
                    wire:click.prevent="deleteImageItem({{ $key }})"
                    @if ($uploadProcess) disabled @endif>
                Delete
            </button>
        </div>
    @endforeach
    @if (count($forUpload))
        <div class="col w-full">
            <button type="button" class="btn"
                    wire:click="startUploadImages" wire:loading.attr="disabled"
                    @if ($uploadProcess) disabled @endif>
                Load
            </button>
        </div>
    @endif
</div>
