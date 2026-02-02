@props(['variant' => 'blue', 'icon' => false])

@php
    // Normal base (default)
    $base = 'inline-flex items-center justify-center gap-2 rounded-lg text-base font-semibold leading-6 px-4 py-2 transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2';

    // Smaller base for icon buttons (square, no gap, smaller font)
    $iconBase = 'inline-flex items-center justify-center rounded-md text-sm leading-5 p-1 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-1';

    // Select base depending on icon prop
    $baseClasses = $icon ? $iconBase : $base;

    $styles = [
        // Solid variants
        'blue'    => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
        'indigo'  => 'bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500',
        'red'     => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
        'green'   => 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500',
        'yellow'  => 'bg-yellow-400 text-gray-900 hover:bg-yellow-500 focus:ring-yellow-400',
        'gray'    => 'bg-gray-300 text-gray-900 hover:bg-gray-400 focus:ring-gray-400',

        // Outlined variants
        'outline-blue'   => 'bg-transparent text-blue-600 border-2 border-blue-600 hover:bg-blue-50 focus:ring-blue-500',
        'outline-indigo' => 'bg-transparent text-indigo-600 border-2 border-indigo-600 hover:bg-indigo-50 focus:ring-indigo-500',
        'outline-red'    => 'bg-transparent text-red-600 border-2 border-red-600 hover:bg-red-50 focus:ring-red-500',
        'outline-green'  => 'bg-transparent text-green-600 border-2 border-green-600 hover:bg-green-50 focus:ring-green-500',
        'outline-yellow' => 'bg-transparent text-yellow-400 border-2 border-yellow-400 hover:bg-yellow-50 focus:ring-yellow-400',
        'outline-gray'   => 'bg-transparent text-gray-700 border-2 border-gray-400 hover:bg-gray-100 focus:ring-gray-400',

        // Ghost / Link
        'ghost' => 'bg-transparent text-gray-800 hover:bg-gray-100 focus:ring-gray-300',
        'link'  => 'bg-transparent text-blue-600 underline hover:text-blue-700 focus:ring-transparent',

        // Aliases
        'primary'   => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
        'secondary' => 'bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500',

        // Close
        'close' => 'bg-white hover:opacity-50',
    ];

    $selected = $variant ?? 'blue';
    $styleClasses = $styles[$selected] ?? $styles['blue'];
@endphp

<button {{ $attributes->twMerge(['class' => "cursor-pointer {$baseClasses} {$styleClasses}"]) }}>
    {{ $slot }}
</button>