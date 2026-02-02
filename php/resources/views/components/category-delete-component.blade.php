<form action="{{$attributes['action'] ?? ''}}" method="POST" class="p-3 flex flex-col gap-2 items-center">
    @csrf
    @method('DELETE')
    <h1>Are you sure you want to delete this category?</h1>
    <div class="flex flex-row gap-3 items-center justify-between">
        <x-button variant="primary" type="submit">Yes</x-button>
        <x-button variant="red" data-modal-close type="button">Cancel</x-button>
    </div>
</form>