<form action="{{$attributes['action'] ?? ''}}" method="POST" class="p-3 flex flex-col gap-2">
    @csrf
    @if($attributes['method'] == 'PUT')
        @method('PUT')
    @endif
    <div>
        <label for="product_id" class="block mb-2.5 text-sm font-medium text-heading">Product</label>
        <select name="product_id" id="product_id" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required>
            <option value="" disabled>Select option</option>
            @if(isset($products))
                @forelse (json_decode(html_entity_decode($products), true) as $item)
                    <option value="{{$item['id']}}">{{$item['name']}}</option>
                @empty
                    <option value="" disabled>No data</option>
                @endforelse
            @endif
        </select>
    </div>
    <div>
        <label for="stocked_count" class="block mb-2.5 text-sm font-medium text-heading">Stock Count</label>
        <input type="number" min="0" id="stocked_count" name="stocked_count" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required />
    </div>
    <div>
        <label for="stocked_date" class="block mb-2.5 text-sm font-medium text-heading">Stocked Date</label>
        <input type="date" id="stocked_date" name="stocked_date" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required />
    </div>
    <x-button variant="primary" type="submit">Submit</x-button>
</form>
