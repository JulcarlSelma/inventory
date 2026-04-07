@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-3">
    @if ($errors->any())
        <x-card class="bg-red-500 py-2 px-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="text-white">{{ $error }}</li>
                @endforeach
            </ul>
        </x-card>
    @endif
    <div class="flex flex-row gap-2">
        <x-card>
            <x-slot:header>
                Filters
            </x-slot:header>
            <div class="p-2 w-full flex flex-row gap-3 items-end justify-between">
                <form method="GET" class="w-full flex flex-row items-end justify-between gap-3">
                    <div class="w-full">
                        <label for="name" class="block mb-2.5 text-sm font-medium text-heading">Name</label>
                        <input type="text" id="name" name="name" value="{{old('name')}}" class="border border-gray-200 text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="Enter product name" />
                    </div>
                    <div class="w-full">
                        <label for="category" class="block mb-2.5 text-sm font-medium text-heading">Category</label>
                        <select name="category" id="category" class="border border-gray-200 text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body">
                            <option value="" disabled>Select option</option>
                            @forelse ($dropdown as $item)
                                <option value="{{$item['id']}}">{{$item['name']}}</option>
                            @empty
                                <option value="" disabled>No data</option>
                            @endforelse
                        </select>
                    </div>
                    <x-button type="submit" variant="primary">Submit</x-button>
                </form>
                <form action="{{route('stock.index')}}" method="GET">
                    <x-button variant="gray">Clear</x-button>
                </form>
            </div>
        </x-card>
        <x-card class="w-[300px]">
            <x-slot:header>
                Barcode auto search
            </x-slot:header>
            <div class="p-2 w-full">
                <form method="GET" id="barcodeForm" class="w-full h-full flex flex-row items-end justify-center gap-3" autocomplete="off">
                    <x-button id="scanModeBtn" type="button" variant="primary" class="w-full {{request()->has('barcode') ? 'hidden' : 'inline-flex'}}">Scan mode</x-button>
                    <div id="barcodeInput" class="w-full {{request()->has('barcode') ? 'block' : 'hidden'}}">
                        <label for="name" class="block mb-2.5 text-sm font-medium text-heading">Barcode</label>
                        <input type="text" id="barcode" name="barcode" value="{{request()->get('barcode')}}" onblur="this.focus()" autofocus class="border border-gray-200 text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="Enter product name" />
                    </div>
                </form>
            </div>
        </x-card>
    </div>
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
                            <th scope="col" class="px-6 py-3 font-medium"></th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Barcode
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Product name
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Category
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Count
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Out of stock
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            <tr class="odd:bg-neutral-primary even:bg-neutral-secondary-soft border-b border-gray-200">
                                <td class="px-6 py-4 font-medium whitespace-nowrap">{{$item['id']}}</td>
                                <td class="whitespace-nowrap"><x-arrow class="w-8 h-auto collapsible-button transition-transform" data-collapse-id="history-{{$item['id']}}"/></td>
                                <td class="px-6 py-4 font-medium whitespace-nowrap flex flex-col items-center gap-1">
                                    <div>
                                        {!! DNS1D::getBarcodeHTML($item['product']['barcode'], 'C128', 2, 50) !!}
                                    </div>
                                    <span>{{$item['product']['barcode']}}</span>
                                </td>
                                <td class="px-6 py-4 font-medium whitespace-nowrap">{{$item['product']['name']}}</td>
                                <td class="px-6 py-4 font-medium whitespace-nowrap">{{$item['product']['category']['name']}}</td>
                                <td class="px-6 py-4 font-medium whitespace-nowrap">{{$item['stocked_count']}}</td>
                                <td class="px-6 py-4 font-medium whitespace-nowrap">{{$item['stocked_count'] <= 0 ? 'True' : 'False'}}</td>
                            </tr>
                            <tr id="history-{{$item['id']}}" class="hidden odd:bg-neutral-primary even:bg-neutral-secondary-soft border-b border-gray-200">
                                <td colspan="8" class="px-6 py-4 text-center font-medium whitespace-nowrap">
                                    <table class="bg-white w-full text-sm text-left rtl:text-right text-body">
                                        <thead class="bg-neutral-secondary-soft border-b border-gray-200">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 font-medium">
                                                    ID
                                                </th>
                                                <th scope="col" class="px-6 py-3 font-medium">
                                                    Type
                                                </th>
                                                <th scope="col" class="px-6 py-3 font-medium">
                                                    Count
                                                </th>
                                                <th scope="col" class="px-6 py-3 font-medium">
                                                    Details
                                                </th>
                                                <th scope="col" class="px-6 py-3 font-medium">
                                                    Requestor
                                                </th>
                                                <th scope="col" class="px-6 py-3 font-medium">
                                                    Approved By
                                                </th>
                                                <th scope="col" class="px-6 py-3 font-medium">
                                                    Date
                                                </th>
                                                <th scope="col" class="px-6 py-3 font-medium">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($item['history'] as $history)
                                                <tr class="odd:bg-neutral-primary even:bg-neutral-secondary-soft border-b border-gray-200">
                                                    <td class="px-6 py-4 font-medium whitespace-nowrap">{{$history['id']}}</td>
                                                    <td class="px-6 py-4 font-medium whitespace-nowrap">{{$history['type']}}</td>
                                                    <td class="px-6 py-4 font-medium whitespace-nowrap">{{$history['count']}}</td>
                                                    <td class="px-6 py-4 font-medium whitespace-nowrap">{{$history['details']}}</td>
                                                    <td class="px-6 py-4 font-medium whitespace-nowrap">{{$history['requestor']}}</td>
                                                    <td class="px-6 py-4 font-medium whitespace-nowrap">{{$history['approved_by']}}</td>
                                                    <td class="px-6 py-4 font-medium whitespace-nowrap">{{$history['date']}}</td>
                                                    <td class="px-6 py-4 font-medium whitespace-nowrap flex flex-row gap-2 items-center justify-centers">
                                                        <button
                                                            class="text-white bg-green-600 rounded-md py-2 px-3"
                                                            data-modal-open
                                                            data-trigger="edit"
                                                            data-id="{{$item['id']}}"
                                                            data-history_id="{{$history['id']}}"
                                                            data-product_id="{{$item['product']['id']}}"
                                                            data-type="{{$history['type']}}"
                                                            data-count="{{$history['count']}}"
                                                            data-details="{{$history['details']}}"
                                                            data-requestor="{{$history['requestor']}}"
                                                            data-approved_by="{{$history['approved_by']}}"
                                                            data-date="{{$history['date']}}"
                                                        >Edit</button>
                                                        <button
                                                            class="text-white bg-red-800 rounded-md py-2 px-3"
                                                            data-modal-open data-trigger="delete"
                                                            data-id="{{$history['id']}}"
                                                            data-product_id="{{$item['product']['id']}}"
                                                        >Delete</button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr class="odd:bg-neutral-primary even:bg-neutral-secondary-soft border-b border-gray-200">
                                                    <td colspan="8" class="px-6 py-4 text-center font-medium whitespace-nowrap">No History Found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @empty
                            <tr class="odd:bg-neutral-primary even:bg-neutral-secondary-soft border-b border-gray-200">
                                <td colspan="7" class="px-6 py-4 text-center font-medium whitespace-nowrap">No Data Found</td>
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
                document.getElementById('scanModeBtn').classList.remove('hidden');
                document.getElementById('scanModeBtn').classList.add('inline-flex');
                document.getElementById('barcodeInput').classList.add('hidden');
                const trigger = btn.dataset.trigger
                const id = btn.dataset.id
                const history_id = btn.dataset.history_id
                const product_id = btn.dataset.product_id
                const count = btn.dataset.count
                const date = btn.dataset.date
                const details = btn.dataset.details
                const requestor = btn.dataset.requestor
                const approved_by = btn.dataset.approved_by
                const type = btn.dataset.type
                document.getElementById('header').innerHTML = trigger.toUpperCase()
                switch (trigger) {
                    case 'edit':
                        document.getElementById('content').innerHTML = `<x-stock-form action="{{ route('stock.update', ':id') }}" method="PUT" products="{{$products}}"/>`.replace(':id', id);
                        document.getElementById('product_id').value = product_id
                        document.getElementById('history_id').value = history_id
                        document.getElementById('stocked_count').value = count
                        document.getElementById('date').value = date
                        document.getElementById('details').value = details
                        document.getElementById('requestor').value = requestor
                        document.getElementById('approved_by').value = approved_by
                        document.getElementById('type').value = type
                        break;  
                    case 'add':
                        document.getElementById('content').innerHTML = `<x-stock-form action="{{route('stock.store')}}" products="{{$products}}" />`;
                        break;
                    case 'delete':
                        document.getElementById('content').innerHTML = `<x-stock-delete action="{{route('stock.destroy', ':id')}}" />`.replace(':id', id);
                        break;
                }
            })
        })

        document.querySelectorAll('.collapsible-button').forEach((btn) => {
            btn.addEventListener('click', () => {
                const collapseId = btn.dataset.collapseId
                const collapseElement = document.getElementById(collapseId)
                collapseElement.classList.toggle('hidden')
                if (!btn.classList.contains('rotate-[180deg]')) {
                    btn.classList.add('rotate-[180deg]');
                } else {
                    btn.classList.remove('rotate-[180deg]');
                }
            })
        })

        document.getElementById('scanModeBtn').addEventListener('click', (btn) => {
            const inputContainer = document.getElementById('barcodeInput');
            inputContainer.classList.remove('hidden');
            inputContainer.querySelector('input').focus();
            btn.target.classList.remove('inline-flex');
            btn.target.classList.add('hidden');
        });
        let timer;

        document.getElementById('barcode').addEventListener('input', function() {
            clearTimeout(timer);

            timer = setTimeout(() => {
                if (this.value.trim() !== '') {
                    document.getElementById('barcodeForm').submit();
                }
            }, 200); // small delay to allow full scan
        });
    })({});
</script>
@endpush
