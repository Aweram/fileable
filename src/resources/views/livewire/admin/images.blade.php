<div class="row">
    <div class="col w-full">
        <div class="card">
            <div class="card-body">
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
