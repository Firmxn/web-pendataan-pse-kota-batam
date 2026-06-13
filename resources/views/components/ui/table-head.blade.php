<thead
    {{ $attributes->merge(['class' => 'bg-transparent text-base-content font-medium text-sm [&>tr>th]:font-medium [&>tr>th]:uppercase [&>tr>th]:tracking-wider']) }}>
    {{ $slot }}
</thead>
