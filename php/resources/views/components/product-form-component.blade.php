<form action="{{$attributes['action'] ?? ''}}" method="POST" class="p-3 flex flex-col gap-2">
    @csrf
    @if($attributes['method'] == 'PUT')
        @method('PUT')
    @endif
    <div>
        <label for="name" class="block mb-2.5 text-sm font-medium text-heading">Product name</label>
        <input type="text" id="name" name="name" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="Wire" required />
    </div>
    <div>
        <label for="description" class="block mb-2.5 text-sm font-medium text-heading">Description</label>
        <textarea id="description" name="description" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"></textarea>
    </div>
    <div>
        <label for="sku" class="block mb-2.5 text-sm font-medium text-heading">SKU</label>
        <input type="text" id="sku" name="sku" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" />
    </div>
    <div>
        <label for="price" class="block mb-2.5 text-sm font-medium text-heading">Cost Price</label>
        <input type="number" id="price" name="price" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="20" required />
    </div>
    <div>
        <label for="selling_price" class="block mb-2.5 text-sm font-medium text-heading">Selling Price</label>
        <input type="number" id="selling_price" name="selling_price" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="20" />
    </div>
    <div>
        <label for="category_id" class="block mb-2.5 text-sm font-medium text-heading">Category</label>
        <select name="category_id" id="category_id" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body">
            <option value="" disabled>Select option</option>
            @if(isset($dropdown))
                @forelse (json_decode(html_entity_decode($dropdown), true) as $item)
                    <option value="{{$item['id']}}">{{$item['name']}}</option>
                @empty
                    <option value="" disabled>No data</option>
                @endforelse
            @endif
        </select>
    </div>
    <x-button variant="primary" type="submit">Submit</x-button>
</form>
