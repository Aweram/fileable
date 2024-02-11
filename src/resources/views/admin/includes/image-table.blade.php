<x-tt::table>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading sortable
                                 wire:click="changeSort('name')"
                                 :direction="$sortBy == 'name' ? $sortDirection : null">
                {{ __("File") }}
            </x-tt::table.heading>
            <x-tt::table.heading>{{ __("Actions") }}</x-tt::table.heading>
        </tr>
    </x-slot>
    <x-slot name="body">
        @foreach($gallery as $item)
            <tr>
                <td>
                    <a href="{{ route("thumb-img", ["template" => "original", "filename" => $item->file_name]) }}" target="_blank">
                        <img src="{{ route("thumb-img", ["template" => "gallery-preview", "filename" => $item->file_name]) }}"
                             alt="{{ $item->name }}" class="rounded-lg">
                    </a>
                    <br>
                    @if ($displayName && $imageId == $item->id)
                        <div class="flex justify-start">
                            <input type="text" class="form-control rounded-r-none border-r-0 @if ($errors->has('name')) border-danger @endif"
                                   aria-label="File name"
                                   wire:model="name">
                            <button type="button" class="btn btn-outline-dark rounded-r-none rounded-l-none border-r-0"
                                    wire:click="closeEditName">
                                {{ __("Cancel") }}
                            </button>
                            <button type="button" class="btn btn-outline-primary rounded-l-none"
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
                </td>
                <td>
                    <div class="flex justify-center">
                        <button type="button" class="btn btn-danger px-btn-x-ico"
                                wire:loading.attr="disabled"
                                wire:click="showDelete({{ $item->id }})">
                            <x-tt::ico.trash />
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-tt::table>
