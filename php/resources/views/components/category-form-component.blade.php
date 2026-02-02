
<form action="{{$attributes['action'] ?? ''}}" method="POST" class="p-3 flex flex-col gap-2">
    @csrf
    @if($attributes['method'] == 'PUT')
        @method('PUT')
    @endif
    <div>
        <label for="first_name" class="block mb-2.5 text-sm font-medium text-heading">Category name</label>
        <input type="text" id="categoryName" name="name" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="Wire" required />
    </div>
    <x-button variant="primary" type="submit">Submit</x-button>
</form>
