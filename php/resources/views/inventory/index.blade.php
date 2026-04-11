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
                    <label for="product_id" class="block mb-2.5 text-sm font-medium text-heading">Products</label>
                    <select name="product_id" value="{{request('product_id')}}" id="product_id" class="border border-gray-200 text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body">
                        <option value="all" selected>All</option>
                        @forelse ($products as $item)
                            <option value="{{$item['id']}}" {{request('product_id') == $item['id'] ? 'selected' : ''}}>{{$item['name']}}</option>
                        @empty
                            <option value="" disabled>No data</option>
                        @endforelse
                    </select>
                </div>
                <div class="w-full">
                    <label for="name" class="block mb-2.5 text-sm font-medium text-heading">Date Range</label>
                    <div class="flex flex-row gap-2 items-center">
                        <input type="date" id="start_date" name="start_date" value="{{request('start_date')}}" class="border border-gray-200 text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" />
                        <input type="date" id="end_date" name="end_date" value="{{request('end_date')}}" class="border border-gray-200 text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" />
                    </div>
                </div>
                <div class="w-full">
                    <label for="type" class="block mb-2.5 text-sm font-medium text-heading">Transaction</label>
                    <select name="type" value="{{request('type')}}" class="border border-gray-200 text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body">
                        <option value="all" selected>All</option>
                        <option value="in" {{request('type') == "in" ? 'selected' : ''}}>IN</option>
                        <option value="out" {{request('type') == "out" ? 'selected' : ''}}>OUT</option>
                    </select>
                </div>
                <div class="w-full">
                    <label for="category_id" class="block mb-2.5 text-sm font-medium text-heading">Category</label>
                    <select name="category_id" value="{{request('category_id')}}" id="category_id" class="border border-gray-200 text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body">
                        <option value="all" selected>All</option>
                        @forelse ($dropdown as $item)
                            <option value="{{$item['id']}}" {{request('category_id') == $item['id'] ? 'selected' : ''}}>{{$item['name']}}</option>
                        @empty
                            <option value="" disabled>No data</option>
                        @endforelse
                    </select>
                </div>
                <x-button type="submit" variant="primary" class="whitespace-nowrap">Generate Report</x-button>
            </form>
            <form action="{{route('inventory')}}" method="GET">
                <x-button variant="gray">Clear</x-button>
            </form>
        </div>
    </x-card>
    @if(empty($stocks))
        <h1 class="text-center text-bold">Please generate report</h1>
    @else
        <x-card class="pb-3">
            <x-slot:header class="flex flex-row justify-between items-center mb-3">
                <h1>Inventory Report Result</h1>
                <x-button variant="outline-green" class="text-xs" onclick="window.print()">Print</x-button>
            </x-slot:header>
            <div class="printable">
                <h1>Inventory Report</h1>
                @if(request('start_date') && request('end_date'))
                    <p>Date Range: <span>{{request('start_date')}} - {{request('end_date')}}</span></p>
                @endif
                <p>Transaction Type: <span>{{request('type')}}</span></p>
                <p>Category: <span>{{request('category_id')}}</span></p>
                @if(request('product_id') && request('product_id') != 'all')
                    <p>Product Name: <span>{{$stocks[0]->product->name}}</span></p>
                @endif
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stocks as $stock)
                            <tr>
                                <td>{{$stock->product->name}}</td>
                                <td>Php {{number_format($stock->product->price, 2)}}</td>
                                <td>{{$stock->product->category->name}}</td>
                                <td class="{{$stock->stocked_count <= 0 ? 'out' : ''}}">{{$stock->stocked_count}}</td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Transaction</th>
                                                <th>Count</th>
                                                <th>Requestor</th>
                                                <th>Approver</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($stock->history as $history)
                                                <tr class="{{$history->type}}">
                                                    <td>{{$history->date}}</td>
                                                    <td>{{$history->type}}</td>
                                                    <td>{{$history->count}}</td>
                                                    <td>{{$history->requestor}}</td>
                                                    <td>{{$history->approved_by}}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5">No data found!</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No Data Found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    @endif
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
                const product_id = btn.dataset.product_id
                const stocked_count = btn.dataset.stocked_count
                const stocked_date = btn.dataset.stocked_date
                document.getElementById('header').innerHTML = trigger.toUpperCase()
                switch (trigger) {
                    case 'edit':
                        document.getElementById('content').innerHTML = `<x-stock-form action="{{ route('stock.update', ':id') }}" method="PUT" products="{{$products}}"/>`.replace(':id', id);
                        document.getElementById('product_id').value = product_id
                        document.getElementById('stocked_count').value = stocked_count
                        document.getElementById('stocked_date').value = stocked_date
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
    })({});
</script>
@endpush
