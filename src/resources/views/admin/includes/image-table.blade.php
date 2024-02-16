<x-tt::table drag-gallery-root>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left">{{ __("File") }}</x-tt::table.heading>
        </tr>
    </x-slot>
    <x-slot name="body">
        @foreach($gallery as $key => $item)
            <tr drag-gallery-item="{{ $item->id }}"
                drag-galley-item-order="{{ $key }}"
                wire:key="{{ $item->id }}">
                <td>
                    <div class="flex">
                        @if (!$hasSearch)
                            <div class="flex items-center">
                                <x-tt::ico.bars drag-gallery-grab class="text-secondary mr-indent cursor-grab" />
                            </div>
                        @endif

                        <a href="{{ route("thumb-img", ["template" => "original", "filename" => $item->file_name]) }}"
                           target="_blank" class="block mr-indent basis-auto">
                            <img src="{{ route("thumb-img", ["template" => "gallery-preview", "filename" => $item->file_name]) }}"
                                 alt="{{ $item->name }}" class="rounded-lg">
                        </a>

                        <div class="flex flex-col justify-between">
                            <div>
                                @if ($displayName && $imageId == $item->id)
                                    <div class="flex justify-start">
                                        <input type="text" class="form-control form-control-sm rounded-r-none border-r-0 @if ($errors->has('name')) border-danger @endif"
                                               aria-label="File name"
                                               wire:model="name">
                                        <button type="button" class="btn btn-sm btn-outline-dark rounded-r-none rounded-l-none border-r-0"
                                                wire:click="closeEditName">
                                            {{ __("Cancel") }}
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-primary rounded-l-none"
                                                wire:click="updateName">
                                            {{ __("Update") }}
                                        </button>
                                    </div>
                                    <x-tt::form.error name="name" />
                                @else
                                    <button type="button" class="underline" wire:click="showEditName({{$item->id}}, '{{$item->name}}')">
                                        {{ $item->name }}
                                    </button>
                                @endif

                                <ul class="text-secondary text-sm flex space-x-indent-half">
                                    <li>{{ $item->human_size }}</li>
                                    <li>{{ __("Loaded") }} {{ $item->created_human }}</li>
                                </ul>
                            </div>
                            <div>
                                <button type="button" class="underline text-sm"
                                        wire:loading.attr="disabled"
                                        wire:click="showDelete({{ $item->id }})">
                                    {{ __("Delete") }}
                                </button>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-tt::table>
