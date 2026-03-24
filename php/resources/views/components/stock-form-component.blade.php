<form action="{{$attributes['action'] ?? ''}}" method="POST" class="p-3 flex flex-col gap-2 max-h-[50vh] overflow-y-auto no-scrollbar">
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
        <label for="type" class="block mb-2.5 text-sm font-medium text-heading">Product</label>
        <select name="type" id="type" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required>
            <option value="IN">IN</option>
            <option value="OUT">OUT</option>
        </select>
    </div>
    <div>
        <label for="date" class="block mb-2.5 text-sm font-medium text-heading">Stocked Date</label>
        <input type="date" id="date" name="date" value="{{ date('Y-m-d') }}" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required />
    </div>
    <div>
        <label for="requestor" class="block mb-2.5 text-sm font-medium text-heading">Requestor</label>
        <input type="text" id="requestor" name="requestor" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" />
    </div>
    <div>
        <label for="approved_by" class="block mb-2.5 text-sm font-medium text-heading">Approver</label>
        <input type="text" id="approved_by" name="approved_by" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" />
    </div>
    <div>
        <label for="details" class="block mb-2.5 text-sm font-medium text-heading">Details</label>
        <textarea id="details" name="details" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"></textarea>
    </div>
    <x-button variant="primary" type="submit">Submit</x-button>
</form>
