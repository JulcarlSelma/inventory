<form action="{{$attributes['action'] ?? ''}}" method="POST" enctype="multipart/form-data" class="p-3 flex flex-col gap-2 max-h-[60vh] overflow-y-auto no-scrollbar">
    @csrf
    @if($attributes['method'] == 'PUT')
        @method('PUT')
    @endif
    <div>
        <label class="block mb-2.5 text-sm font-medium text-heading" for="image_path">Photo:</label>
        <input 
            type="file" 
            name="image_path"
            id="image_path"
            accept="image/*"
            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body @error('image_path') is-invalid @enderror"
        >

        @error('image_path')
            <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
    </div>
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
        <label for="barcode" class="block mb-2.5 text-sm font-medium text-heading">Barcode</label>
        <input type="text" id="barcode" name="barcode" maxlength="50" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" />
    </div>
    <div>
        <label for="serial_number" class="block mb-2.5 text-sm font-medium text-heading">Serial Number</label>
        <input type="text" id="serial_number" name="serial_number" maxlength="100" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" />
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
