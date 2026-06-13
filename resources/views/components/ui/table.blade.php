<div class="overflow-x-auto bg-base-100 border border-base-200 rounded-xl">
    <table {{ $attributes->merge(['class' => 'table w-full text-sm text-left']) }}>
        {{ $slot }}
    </table>
</div>