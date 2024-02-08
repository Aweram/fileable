<x-tt::modal.aside wire:model="displayData">
    <x-slot name="title">{{ __("Add image") }}</x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="store"
              class="space-y-indent-half" id="imageDataForm" enctype="multipart/form-data">
            <div>
                <label for="image" class="inline-block mb-2">{{ __("Image") }}<span class="text-danger">*</span></label>
                <input type="file" name="image" required
                       id="image" class="form-control {{ $errors->has("image") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled" wire:model.lazy="image">
                <x-tt::form.error name="name" />
            </div>

            <div>
                <label for="name" class="inline-block mb-2">{{ __("Name") }}</label>
                <input type="text" name="name"
                       id="name" class="form-control {{ $errors->has("name") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled" wire:model="name">
                <x-tt::form.error name="name" />
            </div>

            <div class="flex items-center space-x-indent-half">
                <button type="button" class="btn btn-outline-dark" wire:click="closeData">
                    {{ __("Cancel") }}
                </button>
                <button type="submit" form="imageDataForm" class="btn btn-primary" wire:loading.attr="disabled">
                    {{ __("Add") }}
                </button>
            </div>
        </form>
    </x-slot>
</x-tt::modal.aside>
