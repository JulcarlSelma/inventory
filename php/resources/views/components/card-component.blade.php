<div {{$attributes->twMerge('w-full bg-white rounded-md shadow-md mt-2')}} >
    @if(isset($header))
        <div {{$header->attributes->twMerge('w-full py-2 px-3 rounded-t-md bg-gray-200')}}>{{$header}}</div>
    @endif
    {{$slot ?? ''}}
</div>