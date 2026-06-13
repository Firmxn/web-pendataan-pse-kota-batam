    @props(['label' => null])

    <fieldset {{ $attributes->merge(['class' => 'fieldset']) }}>
        <legend {{ $attributes->merge(['class' => 'fieldset-legend font-medium text-sm'])}}>{{ $label }}</legend>

        {{ $slot }}
    </fieldset>
