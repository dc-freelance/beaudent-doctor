@props(['id' => '', 'label' => '', 'name' => '', 'required' => false])

<div class="w-full">
    @if ($label)
        <label class="block text-sm mb-2 font-semibold" for="{{ $id }}">
            {{ $label }} {!! $required ? '<span class="text-red-500">*</span>' : '' !!}
        </label>
    @endif
    <div class="w-full">
        <select id="{{ $id }}" name="{{ $name }}" {{ $required ? 'required' : '' }}
            class="block w-full py-2 pl-3 pr-10 text-base bg-gray-50 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md select-input">
            {{ $slot }}
        </select>
    </div>
</div>
