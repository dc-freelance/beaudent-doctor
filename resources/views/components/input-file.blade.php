@props([
    'id' => '',
    'name' => '',
    'label' => '',
    'multiple' => false,
    'required' => false,
])

<div>
    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="{{ $id }}">
        {{ $label }} {!! $required ? '<span class="text-red-500">*</span>' : '' !!}
    </label>
    <input
        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
        id="{{ $id }}" name="{{ $name }}" type="file" {{ $multiple ? 'multiple' : '' }}
        {{ $required ? 'required' : '' }} />

</div>
