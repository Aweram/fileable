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
                    {{ $item->name }}
                    <br>
                    {{ $item->storage }}
                </td>
                <td>Actions</td>
            </tr>
        @endforeach
    </x-slot>
    <x-slot name="caption">
        <div class="flex justify-between">
            <div>{{ __("Total") }}: {{ $gallery->total() }}</div>
            {{ $gallery->links("tt::pagination.live") }}
        </div>
    </x-slot>
</x-tt::table>
