@section('title', __('Edit'))
@section('section', __('Hosting'))

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <x-ui.heading>
                {{ __('Edit Hosting') }}
            </x-ui.heading>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <x-ui.alert-session />
            <x-ui.card :title="__('Formulir Perubahan Data')">
                <form action="{{ route('hosting.update', $hosting) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    @method('PUT')

                    <x-ui.section-divider :spacing="false" class="text-secondary dark:text-accent">
                        {{ __('Informasi Pengajuan') }}
                    </x-ui.section-divider>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.fieldset label="{{ __('PSE/Nama Sistem') }}">
                            <div class="space-y-1">
                                <x-form.select name="pse_id_disabled" disabled>
                                    <option value="{{ $hosting->pse_id }}" selected>
                                        {{ $hosting->pse->system_name }}
                                    </option>
                                </x-form.select>
                                {{-- Hidden input agar nilai tetap terkirim --}}
                                <input type="hidden" name="pse_id" value="{{ $hosting->pse_id }}">
                                <x-form.input-description field="pse_id"
                                    value="{{ __('Tidak dapat diubah karena terintegrasi dengan data PSE.') }}" />
                            </div>
                        </x-form.fieldset>

                        <div class="grid grid-cols-2 gap-4">
                            <x-form.fieldset label="{{ __('Tipe Pengajuan') }}">
                                @if ($hosting->pse->status !== 'approved')
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
                                    <x-form.select name="request_type">
                                        <option value="" disabled>
                                            {{ __('Pilih tipe') }}
                                        </option>
                                        @foreach ($requestTypes as $key => $label)
                                            <option value="{{ $key }}"
                                                {{ old('request_type', $hosting->request_type) == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </x-form.select>
                                    <x-form.input-error :messages="$errors->get('request_type')" />
                                @endif
                            </x-form.fieldset>

                            <x-form.fieldset label="{{ __('Tipe Hosting') }}">
                                <x-form.select name="hosting_type">
                                    <option value="" disabled>
                                        {{ __('Pilih tipe') }}
                                    </option>
                                    @foreach ($hostingTypes as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ old('hosting_type', $hosting->hosting_type) == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </x-form.select>
                                <x-form.input-error :messages="$errors->get('hosting_type')" />
                            </x-form.fieldset>
                        </div>
                    </div>

                    <x-ui.section-divider class="text-secondary dark:text-accent">
                        {{ __('Spesifikasi Server') }}
                    </x-ui.section-divider>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.fieldset label="{{ __('CPU Cores') }}">
                            <x-form.select name="cpu_cores">
                                <option value="" disabled>
                                    {{ __('Pilih jumlah core') }}
                                </option>
                                @foreach ($cpuCores as $core)
                                    <option value="{{ $core }}"
                                        {{ old('cpu_cores', $hosting->cpu_cores) == $core ? 'selected' : '' }}>
                                        {{ $core }} Core
                                    </option>
                                @endforeach
                            </x-form.select>
                            <x-form.input-error :messages="$errors->get('cpu_cores')" />
                        </x-form.fieldset>

                        <x-form.fieldset label="{{ __('RAM Capacity') }}">
                            <x-form.select name="ram_capacity">
                                <option value="" disabled>
                                    {{ __('Pilih kapasitas RAM') }}
                                </option>
                                @foreach ($ramCapacities as $ram)
                                    <option value="{{ $ram }}"
                                        {{ old('ram_capacity', $hosting->ram_capacity) == $ram ? 'selected' : '' }}>
                                        {{ $ram }} GB
                                    </option>
                                @endforeach
                            </x-form.select>
                            <x-form.input-error :messages="$errors->get('ram_capacity')" />
                        </x-form.fieldset>

                        <x-form.fieldset label="{{ __('Storage Capacity') }}">
                            <x-form.select name="storage_capacity">
                                <option value="" disabled>
                                    {{ __('Pilih kapasitas storage') }}
                                </option>
                                @foreach ($storageCapacities as $storage)
                                    <option value="{{ $storage }}"
                                        {{ old('storage_capacity', $hosting->storage_capacity) == $storage ? 'selected' : '' }}>
                                        {{ $storage }} GB
                                    </option>
                                @endforeach
                            </x-form.select>
                            <x-form.input-error :messages="$errors->get('storage_capacity')" />
                        </x-form.fieldset>

                        <x-form.fieldset label="{{ __('Bandwidth Capacity') }}">
                            <x-form.select name="bandwidth_capacity">
                                <option value="" disabled>
                                    {{ __('Pilih kapasitas bandwidth') }}
                                </option>
                                @foreach ($bandwidthCapacities as $bandwidth)
                                    <option value="{{ $bandwidth }}"
                                        {{ old('bandwidth_capacity', $hosting->bandwidth_capacity) == $bandwidth ? 'selected' : '' }}>
                                        {{ $bandwidth >= 1000 ? $bandwidth / 1000 . ' TB' : $bandwidth . ' GB' }}
                                    </option>
                                @endforeach
                            </x-form.select>
                            <x-form.input-error :messages="$errors->get('bandwidth_capacity')" />
                            <x-form.input-description field="bandwidth_capacity" value="{{ __('Per Bulan') }}" />
                        </x-form.fieldset>
                    </div>

                    <x-ui.section-divider class="text-secondary dark:text-accent">
                        {{ __('Dokumen Pendukung & Informasi Tambahan') }}
                    </x-ui.section-divider>

                    <div class="grid grid-cols-1 md:grid-cols-1 gap-2">
                        <x-form.fieldset label="{{ __('Surat Permohonan (PDF)') }}">
                            <x-form.file-input id="surat_permohonan" name="surat_permohonan" accept=".pdf" />
                            <x-form.input-error :messages="$errors->get('surat_permohonan')" />
                            <x-form.input-description field="surat_permohonan" value="{{ __('Ukuran maksimal 5 MB.') }}" />

                            {{-- Tampilkan berkas yang ada --}}
                            <x-form.current-file :document="$hosting->document" />

                            @if ($hosting->document)
                                <x-form.input-description
                                    value="{{ __('Unggah berkas baru akan mengganti berkas lama.') }}" />
                            @endif
                        </x-form.fieldset>

                        
                        <x-form.fieldset label="{{ __('Catatan Tambahan') }}">
                            <x-form.textarea name="notes" rows="6"
                                placeholder="{{ __('Opsional: Jelaskan kebutuhan spesifik lainnya...') }}">
                                {{ old('notes', $hosting->notes) }}
                            </x-form.textarea>
                            <x-form.input-error :messages="$errors->get('notes')" />
                        </x-form.fieldset>
                    </div>

                    <div
                        class="flex items-center justify-end gap-4 mt-6 border-t border-base-200 dark:border-base-content/10 pt-6">
                        <x-button.ghost href="{{ route('hosting.index') }}">
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
