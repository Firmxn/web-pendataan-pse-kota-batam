@section('title', __('Manajemen'))
@section('section', __('Tambah Instansi'))

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center px-4 sm:px-0">
            <x-ui.heading level="2">
                {{ __('Tambah Instansi / OPD Baru') }}
            </x-ui.heading>
            <x-button.ghost href="{{ route('opd.index') }}">
                {{ __('Kembali') }}
            </x-button.ghost>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-ui.alert-session />

            <x-ui.card :title="__('Formulir Instansi')">
                <form action="{{ route('opd.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="space-y-4">
                        {{-- Nama Instansi --}}
                        <x-form.fieldset label="{{ __('Nama Instansi (OPD)') }}">
                            <x-form.text-input id="name" name="name" type="text" :value="old('name')" required
                                autofocus />
                            <x-form.input-error :messages="$errors->get('name')" />
                            <x-form.input-description field="name"
                                value="{{ __('Nama resmi Organisasi Perangkat Daerah atau Instansi.') }}" />
                        </x-form.fieldset>

                        {{-- Tipe --}}
                        <x-form.fieldset label="{{ __('Tipe (Opsional)') }}">
                            <x-form.text-input id="type" name="type" type="text" :value="old('type')" />
                            <x-form.input-error :messages="$errors->get('type')" />
                            <x-form.input-description field="type"
                                value="{{ __('Contoh: Dinas, Badan, Kecamatan, Kelurahan, dll.') }}" />
                        </x-form.fieldset>

                        {{-- Email Resmi --}}
                        <x-form.fieldset label="{{ __('Email Resmi (Opsional)') }}">
                            <x-form.text-input id="email" name="email" type="email" :value="old('email')" />
                            <x-form.input-error :messages="$errors->get('email')" />
                            <x-form.input-description field="email"
                                value="{{ __('Alamat email resmi instansi, contoh: diskominfo@batam.go.id.') }}" />
                        </x-form.fieldset>
                    </div>

                    <div
                        class="flex items-center justify-end gap-4 mt-6 border-t border-base-200 dark:border-base-content/10 pt-6">
                        <x-button.ghost href="{{ route('opd.index') }}">
                            {{ __('Batal') }}
                        </x-button.ghost>
                        <x-button.primary type="submit" icon="check">
                            {{ __('Simpan Instansi') }}
                        </x-button.primary>
                    </div>
                </form>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
