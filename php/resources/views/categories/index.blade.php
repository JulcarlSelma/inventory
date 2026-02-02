@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-3">
    <x-card>
        <x-slot:header>
            Filters
        </x-slot:header>
        <div class="p-2 w-full flex flex-row gap-3 items-end justify-between">
            <form method="GET" class="w-full flex flex-row items-end justify-between gap-3">
                <div class="w-full">
                    <label for="name" class="block mb-2.5 text-sm font-medium text-heading">Name</label>
                    <input type="text" id="name" name="name" value="{{old('name')}}" class="border border-gray-200 text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="Enter Category Name" required />
                </div>
                <x-button type="submit" variant="primary">Submit</x-button>
            </form>
            <form action="{{route('category.index')}}" method="GET">
                <x-button variant="gray">Clear</x-button>
            </form>
        </div>
    </x-card>
    <x-card>
        <x-slot:header class="flex flex-row items-center justify-between">
            <span>Data</span>
            <x-button data-modal-open data-trigger="add">Add</x-button>
        </x-slot:header>
        <div class="p-4">            
            <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-gray-200">
                <table class="w-full text-sm text-left rtl:text-right text-body">
                    <thead class="bg-neutral-secondary-soft border-b border-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-3 font-medium">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Category name
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            <tr class="odd:bg-neutral-primary even:bg-neutral-secondary-soft border-b border-gray-200">
                                <td class="px-6 py-4 font-medium whitespace-nowrap">{{$item['id']}}</td>
                                <td class="px-6 py-4 font-medium whitespace-nowrap">{{$item['name']}}</td>
                                <td class="px-6 py-4 font-medium whitespace-nowrap flex flex-row gap-2 items-center justify-centers">
                                    <button class="text-white bg-green-600 rounded-md py-2 px-3" data-modal-open data-trigger="edit" data-id="{{$item['id']}}" data-name="{{$item['name']}}">Edit</button>
                                    <button class="text-white bg-red-800 rounded-md py-2 px-3" data-modal-open data-trigger="delete" data-id="{{$item['id']}}" data-name="{{$item['name']}}">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr class="odd:bg-neutral-primary even:bg-neutral-secondary-soft border-b border-gray-200">
                                <td colspan="3" class="px-6 py-4 font-medium whitespace-nowrap">No Data Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="py-2 px-3">
                {{ $data->links() }}
            </div>
        </div>
    </x-card>
</div>

<x-modal>
    <x-slot:header class="flex flex-row gap-3" id="header"></x-slot:header>
    <div id="content"></div>
</x-modal>
@endsection
@push('js')
<script>
    (function () {
        document.querySelectorAll('[data-modal-open]').forEach((btn) => {
            btn.addEventListener('click', () => {
                const trigger = btn.dataset.trigger
                const id = btn.dataset.id
                const name = btn.dataset.name
                document.getElementById('header').innerHTML = trigger.toUpperCase()
                switch (trigger) {
                    case 'edit':
                        document.getElementById('content').innerHTML = `<x-category-form action="{{ route('category.update', ':id') }}" method="PUT" />`.replace(':id', id);
                        document.getElementById('categoryName').value = name
                        break;
                    case 'add':
                        document.getElementById('content').innerHTML = `<x-category-form action="{{route('category.store')}}"/>`;
                        break;
                    case 'delete':
                        document.getElementById('content').innerHTML = `<x-category-delete action="{{route('category.destroy', ':id')}}" />`.replace(':id', id);
                        break;
                }
            })
        })
    })({});
</script>
@endpush