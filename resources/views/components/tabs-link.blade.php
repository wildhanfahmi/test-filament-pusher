@props(['active'])
@php

    $index = $attributes['index'];

    if ($index == "first") {
        $classes = "inline-block w-full p-4 border-r border-gray-200 dark:border-gray-700 rounded-s-lg focus:ring-4 focus:ring-blue-300 focus:outline-none";
    } elseif ($index == "last") {
        $classes = "inline-block w-full p-4 border-s-0 border-gray-200 dark:border-gray-700 rounded-e-lg focus:ring-4 focus:outline-none focus:ring-blue-300 ";
    } else{
        $classes = "inline-block w-full p-4 border-r border-gray-200 dark:border-gray-700 focus:ring-4 focus:ring-blue-300 focus:outline-none ";
    }

    if($active ?? false){
        $classes .=' active text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700';
    } else{
        $classes .= 'bg-white hover:text-gray-700 dark:bg-gray-800 dark:hover:text-white dark:hover:bg-gray-700 hover:bg-gray-50';
    }
@endphp
<li class="w-full focus-within:z-10  text-nowrap">
    <a {{ $attributes->merge(['class'=>$classes]) }} aria-current="{{ $active ? 'page' : '' }}">{{ $slot }}</a>
</li>