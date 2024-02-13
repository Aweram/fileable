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

@push("scripts")
    <script type="application/javascript">
        let root = document.querySelector("[drag-gallery-root]")

        root.querySelectorAll("[drag-gallery-item]").forEach(el => {
            el.counter = 0

            el.addEventListener('dragstart', e => {
                el.counter = 0
                e.target.setAttribute('dragging', true)
            })

            el.addEventListener('drop', e => {
                e.target.closest('[drag-gallery-item]').querySelectorAll("td").forEach(td => {
                    td.classList.remove('opacity-50')
                })

                let draggingEl = root.querySelector('[dragging]')
                // TODO: Добавить условие, если элемент был выше, то заменить на after
                e.target.closest('[drag-gallery-item]').before(draggingEl)

                let component = Livewire.find(
                    e.target.closest('[wire\\:id]').getAttribute('wire:id')
                )

                let orderIds = Array.from(root.querySelectorAll('[drag-gallery-item]'))
                    .map(itemEl => itemEl.getAttribute('drag-gallery-item'))
                console.log(orderIds)
                // component.call('$refresh')
            })

            el.addEventListener('dragenter', e => {
                el.counter++
                e.target.closest('[drag-gallery-item]').querySelectorAll("td").forEach(td => {
                    td.classList.add('opacity-50')
                })
                e.preventDefault()
            })

            el.addEventListener('dragover', e => { e.preventDefault() })

            el.addEventListener('dragleave', e => {
                el.counter--
                if (el.counter <= 0)
                    e.target.closest('[drag-gallery-item]').querySelectorAll("td").forEach(td => {
                        td.classList.remove('opacity-50')
                    })
            })

            el.addEventListener('dragend', e => {
                e.target.removeAttribute('dragging')
            })
        })
    </script>
@endpush
