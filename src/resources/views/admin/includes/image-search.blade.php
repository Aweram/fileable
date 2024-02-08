<div class="flex justify-between mb-indent-half">
    <div class="flex flex-col space-y-indent-half md:flex-row md:space-x-indent-half md:space-y-0">
        <input type="text" aria-label="Имя" placeholder="Имя" id="name" class="form-control" wire:model.live="searchName">
        <button type="button" class="btn btn-outline-primary" wire:click="clearSearch">{{ __("Clear") }}</button>
    </div>

    <div>
        <input type="file" name="images" required multiple aria-label="{{ __("Images") }}"
               id="images" class="form-control {{ $errors->has("images") ? "border-danger" : "" }}"
               wire:loading.attr="disabled" wire:model.lazy="images">
    </div>
</div>
