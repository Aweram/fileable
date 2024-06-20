<div class="row">
    <div class="col w-full">
        <div class="card">
            <div class="card-header">
                <h2 class="font-medium text-2xl">{{ __("Gallery") }}</h2>
            </div>
            <div class="card-body space-y-indent-half">
                @include("fa::admin.includes.image-search")
                @include("fa::admin.includes.images-preview")
                <x-tt::notifications.error />
                <x-tt::notifications.success />
            </div>
            @include("fa::admin.includes.image-table")
            @include("fa::admin.includes.image-table-modals")
        </div>
    </div>
</div>

@if ($addScript)
    @include("fa::admin.includes.gallery-draggable-script")
@endif
