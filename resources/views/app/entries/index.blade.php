<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.entries.index_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <div class="mb-5 mt-4">
                    <div class="flex flex-wrap justify-between">
                        <div class="md:w-1/2">
                            <form>
                                <div class="flex items-center w-full">
                                    <x-inputs.text
                                        name="search"
                                        value="{{ $search ?? '' }}"
                                        placeholder="{{ __('crud.common.search') }}"
                                        autocomplete="off"
                                    ></x-inputs.text>

                                    <div class="ml-1">
                                        <button
                                            type="submit"
                                            class="button button-primary"
                                        >
                                            <i class="icon ion-md-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="md:w-1/2 text-right">
                            @can('create', App\Models\Entry::class)
                            <a
                                href="{{ route('entries.create') }}"
                                class="button button-primary"
                            >
                                <i class="mr-1 icon ion-md-add"></i>
                                @lang('crud.common.create')
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead class="text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.entries.inputs.label')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.entries.inputs.date')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.entries.inputs.text')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.entries.inputs.uuid')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.entries.inputs.file')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.entries.inputs.image')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.entries.inputs.datetime')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.entries.inputs.bool')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.entries.inputs.number')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.entries.inputs.json')
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($entries as $entry)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ $entry->label ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $entry->date ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $entry->text ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $entry->uuid ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    @if($entry->file)
                                    <a
                                        href="{{ \Storage::url($entry->file) }}"
                                        target="blank"
                                        ><i
                                            class="mr-1 icon ion-md-download"
                                        ></i
                                        >&nbsp;Download</a
                                    >
                                    @else - @endif
                                </td>
                                <td class="px-4 py-3 text-left">
                                    <x-partials.thumbnail
                                        src="{{ $entry->image ? \Storage::url($entry->image) : '' }}"
                                    />
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $entry->datetime ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $entry->bool ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $entry->number ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <pre>
{{ json_encode($entry->json) ?? '-' }}</pre
                                    >
                                </td>
                                <td
                                    class="px-4 py-3 text-center"
                                    style="width: 134px;"
                                >
                                    <div
                                        role="group"
                                        aria-label="Row Actions"
                                        class="
                                            relative
                                            inline-flex
                                            align-middle
                                        "
                                    >
                                        @can('update', $entry)
                                        <a
                                            href="{{ route('entries.edit', $entry) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i
                                                    class="icon ion-md-create"
                                                ></i>
                                            </button>
                                        </a>
                                        @endcan @can('view', $entry)
                                        <a
                                            href="{{ route('entries.show', $entry) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan @can('delete', $entry)
                                        <form
                                            action="{{ route('entries.destroy', $entry) }}"
                                            method="POST"
                                            onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                        >
                                            @csrf @method('DELETE')
                                            <button
                                                type="submit"
                                                class="button"
                                            >
                                                <i
                                                    class="
                                                        icon
                                                        ion-md-trash
                                                        text-red-600
                                                    "
                                                ></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="11">
                                    <div class="mt-10 px-4">
                                        {!! $entries->render() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
