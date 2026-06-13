@section('title', __('Edit'))
@section('section', __('Subdomain'))

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <x-ui.heading>
                {{ __('Edit Subdomain') }}
            </x-ui.heading>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <x-ui.alert-session />

            <x-ui.card :title="__('Formulir Perubahan Data')">
                <form action="{{ route('subdomain.update', $subdomain) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    @method('PUT')

                    <x-ui.section-divider :spacing="false" class="text-secondary dark:text-accent">
                        {{ __('Informasi Subdomain') }}
                    </x-ui.section-divider>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.fieldset label="{{ __('PSE/Nama Sistem') }}">
                            <div class="space-y-1">
                                <x-form.select name="pse_id_disabled" disabled>
                                    <option value="{{ $subdomain->pse_id }}" selected>
                                        {{ $subdomain->pse->system_name }}
                                    </option>
                                </x-form.select>
                                {{-- Hidden input agar nilai tetap terkirim --}}
                                <input type="hidden" name="pse_id" value="{{ $subdomain->pse_id }}">
                                <x-form.input-description field="pse_id"
                                    value="{{ __('Tidak dapat diubah karena terintegrasi dengan data PSE.') }}" />
                            </div>
                        </x-form.fieldset>

                        <x-form.fieldset label="{{ __('Tipe Pengajuan') }}">
                            @if ($subdomain->pse->status !== 'approved')
                                <div class="space-y-1">
                                    <x-form.select name="request_type_disabled" disabled>
                                        <option value="baru" selected>
                                            {{ __('Baru') }}
                                        </option>
                                    </x-form.select>
                                    <input type="hidden" name="request_type" value="baru">
                                    <x-form.input-description field="request_type"
                                        value="{{ __('Tipe terkunci (PSE Draf).') }}" />
                                </div>
                            @else
                                <x-form.select name="request_type" :value="old('request_type', $subdomain->request_type)">
                                    <option value="" disabled>
                                        {{ __('Pilih tipe pengajuan') }}
                                    </option>
                                    @foreach ($requestTypes as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ old('request_type', $subdomain->request_type) == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </x-form.select>
                                <x-form.input-error :messages="$errors->get('request_type')" />
                                <x-form.input-description field="request_type"
                                    value="{{ __('Pilih jenis pengajuan subdomain.') }}" />
                            @endif
                        </x-form.fieldset>

                        <x-form.fieldset label="{{ __('Nama Subdomain') }}">
                            <x-form.text-input name="subdomain_name" :value="old('subdomain_name', $subdomain->subdomain_name)"
                                placeholder="{{ __('Contoh: api, admin, portal') }}" />
                            <x-form.input-error :messages="$errors->get('subdomain_name')" />
                            <x-form.input-description field="subdomain_name"
                                value="{{ __('Masukkan nama subdomain (tanpa suffix).') }}" />
                        </x-form.fieldset>
                    </div>

                    <x-ui.section-divider class="text-secondary dark:text-accent">
                        {{ __('Dokumen Pendukung') }}
                    </x-ui.section-divider>

                    <div class="grid grid-cols-1 gap-4">
                        {{-- surat permohonan --}}
                        <x-form.fieldset label="{{ __('Surat Permohonan (PDF)') }}">
                            <x-form.file-input id="surat_permohonan" name="surat_permohonan" accept=".pdf" />
                            <x-form.input-error :messages="$errors->get('surat_permohonan')" />
                            <x-form.input-description field="surat_permohonan" value="{{ __('Ukuran maksimal 5 MB.') }}" />

                            {{-- Tampilkan berkas yang ada --}}
                            <x-form.current-file :document="$subdomain->document" />

                            @if ($subdomain->document)
                                <x-form.input-description
                                    value="{{ __('Unggah berkas baru akan mengganti berkas lama.') }}" />
                            @endif
                        </x-form.fieldset>
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-base-200 dark:border-base-content/10">
                        <x-button.ghost href="{{ $backUrl ?? route('subdomain.index') }}">
                            {{ __('Batal') }}
                        </x-button.ghost>
                        <x-button.primary>
                            {{ __('Perbarui') }}
                        </x-button.primary>
                    </div>
                </form>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
