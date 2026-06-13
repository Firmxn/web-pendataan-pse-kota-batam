@section('title', __('Edit'))

<x-app-layout>
    <x-slot name="header">
        <x-ui.heading>
            {{ __('Edit PSE') }}
        </x-ui.heading>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <x-ui.alert-session />

            <form method="POST" action="{{ route('pse.update', $pse) }}" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PATCH')

                <x-ui.card :title="__('Formulir Perubahan Data')">
                    <div class="space-y-4">

                        <x-ui.section-divider :spacing="false" class="text-secondary dark:text-accent">
                            {{ __('Informasi Sistem') }}
                        </x-ui.section-divider>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-form.fieldset label="{{ __('Nama Sistem Elektronik') }}">
                                <x-form.text-input name="system_name" type="text" :value="old('system_name', $pse->system_name)" autofocus />
                                <x-form.input-error :messages="$errors->get('system_name')" />
                                <x-form.input-description field="system_name"
                                    value="{{ __('Nama lengkap sistem elektronik yang akan didaftarkan.') }}" />
                            </x-form.fieldset>

                            <x-form.fieldset label="{{ __('Sektor') }}">
                                <x-form.select name="sector">
                                    <option value="" disabled>
                                        {{ __('Pilih Sektor') }}
                                    </option>
                                    @foreach ($sectors as $key => $label)
                                        <option value="{{ $key }}" @selected(old('sector', $pse->sector) === $key)>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </x-form.select>
                                <x-form.input-error :messages="$errors->get('sector')" />
                                <x-form.input-description field="sector"
                                    value="{{ __('Sektor atau bidang layanan sistem elektronik.') }}" />
                            </x-form.fieldset>
                        </div>

                        <x-form.fieldset label="{{ __('Daftar Subdomain') }}">
                            @php
                                $subdomainRequests = $pse->subdomainRequests->where('request_type', 'baru');
                                $subdomains = old(
                                    'subdomains',
                                    $subdomainRequests->pluck('subdomain_name')->toArray(),
                                );
                                $firstSubdomain = $subdomainRequests->first();
                            @endphp
                            <x-form.chips-input name="subdomains" :value="$subdomains" :hasError="$errors->has('subdomains')"
                                placeholder="{{ __('Ketik Nama Subdomain (contoh: portal-layanan) lalu tekan Enter...') }}" />
                            <x-form.input-error :messages="$errors->get('subdomains')" />
                            <x-form.input-description field="subdomains"
                                value="{{ __('Masukkan satu atau lebih subdomain. Subdomain pertama yang dimasukkan akan menjadi domain utama.') }}" />
                        </x-form.fieldset>

                        <x-form.fieldset label="{{ __('Surat Permohonan Subdomain (PDF)') }}">
                            <x-form.file-input name="surat_subdomain" accept=".pdf" />

                            {{-- Tampilkan surat yang sudah ada menggunakan komponen standar --}}
                            <x-form.current-file :document="$firstSubdomain?->document" />

                            <x-form.input-error :messages="$errors->get('surat_subdomain')" />
                            <x-form.input-description field="surat_subdomain"
                                value="{{ __('Kosongkan jika tidak ada perubahan. Maksimal 5 MB.') }}" />
                        </x-form.fieldset>

                        <x-form.fieldset label="{{ __('Deskripsi Sistem') }}">
                            <x-form.textarea name="description" rows="6">
                                {{ old('description', $pse->description) }}
                            </x-form.textarea>
                            <x-form.input-error :messages="$errors->get('description')" />
                            <x-form.input-description field="description"
                                value="{{ __('Opsional. Deskripsi singkat sistem elektronik.') }}" />
                        </x-form.fieldset>

                        <x-ui.section-divider class="text-secondary dark:text-accent">
                            {{ __('Informasi Penanggung Jawab') }}
                        </x-ui.section-divider>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <x-form.fieldset label="{{ __('Nama PIC') }}">
                                <x-form.text-input name="pic_name" type="text" :value="old('pic_name', $pse->pic_name)" />
                                <x-form.input-error :messages="$errors->get('pic_name')" />
                                <x-form.input-description field="pic_name"
                                    value="{{ __('Nama lengkap penanggung jawab sistem.') }}" />
                            </x-form.fieldset>

                            <x-form.fieldset label="{{ __('Nomor Telepon PIC') }}">
                                <x-form.text-input name="pic_phone" type="tel" :value="old('pic_phone', $pse->pic_phone)" />
                                <x-form.input-error :messages="$errors->get('pic_phone')" />
                                <x-form.input-description field="pic_phone"
                                    value="{{ __('Nomor telepon yang dapat dihubungi.') }}" />
                            </x-form.fieldset>

                            <x-form.fieldset label="{{ __('Email PIC') }}">
                                <x-form.text-input name="pic_email" type="email" :value="old('pic_email', $pse->pic_email)" />
                                <x-form.input-error :messages="$errors->get('pic_email')" />
                                <x-form.input-description field="pic_email"
                                    value="{{ __('Alamat email aktif penanggung jawab.') }}" />
                            </x-form.fieldset>
                        </div>

                        <x-ui.section-divider class="text-secondary dark:text-accent">
                            {{ __('Klasifikasi Data & Penyimpanan') }}
                        </x-ui.section-divider>

                        <x-form.fieldset label="{{ __('Kategori Risiko') }}">
                            <x-form.select name="risk_category">
                                <option value="" disabled>
                                    {{ __('Pilih Kategori Risiko') }}
                                </option>
                                @foreach ($riskCategories as $key => $label)
                                    <option value="{{ $key }}" @selected(old('risk_category', $pse->risk_category) === $key)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </x-form.select>
                            <x-form.input-error :messages="$errors->get('risk_category')" />
                            <x-form.input-description field="risk_category"
                                value="{{ __('Tingkat risiko keamanan sistem elektronik.') }}" />
                        </x-form.fieldset>

                        <x-form.fieldset label="{{ __('Klasifikasi Data') }}">
                            <x-form.select name="data_classification">
                                <option value="" disabled>
                                    {{ __('Pilih Klasifikasi Data') }}
                                </option>
                                @foreach ($dataClassifications as $key => $label)
                                    <option value="{{ $key }}" @selected(old('data_classification', $pse->data_classification) === $key)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </x-form.select>
                            <x-form.input-error :messages="$errors->get('data_classification')" />
                            <x-form.input-description field="data_classification"
                                value="{{ __('Tingkat kerahasiaan data yang dikelola sistem.') }}" />
                        </x-form.fieldset>

                        <x-form.fieldset label="{{ __('Informasi Data Pribadi') }}">
                            <x-form.textarea name="private_data_info" rows="6">
                                {{ old('private_data_info', $pse->private_data_info) }}
                            </x-form.textarea>
                            <x-form.input-error :messages="$errors->get('private_data_info')" />
                            <x-form.input-description field="private_data_info"
                                value="{{ __('Opsional. Jelaskan jenis data pribadi yang dikelola.') }}" />
                        </x-form.fieldset>

                        <x-form.fieldset label="{{ __('Lokasi Penyimpanan Data') }}">
                            <div class="flex flex-col sm:flex-row gap-4">
                                @foreach ($storageLocations as $key => $label)
                                    <x-form.radio name="storage_location" :value="$key" :label="$label"
                                        :checked="old('storage_location', $pse->storage_location) === $key" />
                                @endforeach
                            </div>
                            <x-form.input-error :messages="$errors->get('storage_location')" />
                            <x-form.input-description field="storage_location"
                                value="{{ __('Pilih infrastruktur penyimpanan data sistem Anda.') }}" />
                        </x-form.fieldset>
                    </div>
                    <div id="btn-section-main"
                        class="flex items-center justify-end gap-4 mt-6 border-t border-base-200 dark:border-base-content/10 pt-6">
                        <x-button.ghost href="{{ $backUrl ?? route('pse.index') }}">
                            {{ __('Batal') }}
                        </x-button.ghost>
                        <x-button.primary>
                            {{ __('Perbarui') }}
                        </x-button.primary>
                    </div>
                </x-ui.card>

                @php
                    $existingHosting = $pse->hostingRequests->first();
                @endphp

                {{-- Card Hosting Terpisah (Muncul hanya jika Aplikasi) --}}
                <div id="hosting-section" class="hidden">
                    <x-ui.card :title="__('Formulir Perubahan Data Hosting')">
                        <div class="space-y-4">
                            <x-ui.section-divider :spacing="false" class="text-secondary dark:text-accent">
                                {{ __('Informasi Pengajuan Hosting') }}
                            </x-ui.section-divider>
                            <p class="text-sm text-base-content/70 italic">
                                {{ __('Informasi ini akan terupdate jika Lokasi Penyimpanan adalah "Aplikasi".') }}
                            </p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-form.fieldset label="{{ __('Tipe Pengajuan') }}">
                                    <x-form.select name="hosting_request_type">
                                        @foreach ($hostingMetadata['request_types'] as $key => $label)
                                            <option value="{{ $key }}" @selected(old('hosting_request_type', $existingHosting->request_type ?? 'baru') === $key)>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </x-form.select>
                                    <x-form.input-error :messages="$errors->get('hosting_request_type')" />
                                </x-form.fieldset>

                                <x-form.fieldset label="{{ __('Tipe Hosting') }}">
                                    <x-form.select name="hosting_type">
                                        @foreach ($hostingMetadata['hosting_types'] as $key => $label)
                                            <option value="{{ $key }}" @selected(old('hosting_type', $existingHosting->hosting_type ?? 'vps') === $key)>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </x-form.select>
                                    <x-form.input-error :messages="$errors->get('hosting_type')" />
                                </x-form.fieldset>

                                <x-form.fieldset label="{{ __('CPU Cores') }}">
                                    <x-form.select name="cpu_cores">
                                        @foreach ($hostingMetadata['cpu_cores'] as $core)
                                            <option value="{{ $core }}" @selected(old('cpu_cores', $existingHosting->cpu_cores ?? 2) == $core)>
                                                {{ $core }} Core
                                            </option>
                                        @endforeach
                                    </x-form.select>
                                    <x-form.input-error :messages="$errors->get('cpu_cores')" />
                                </x-form.fieldset>

                                <x-form.fieldset label="{{ __('RAM Capacity') }}">
                                    <x-form.select name="ram_capacity">
                                        @foreach ($hostingMetadata['ram_capacities'] as $ram)
                                            <option value="{{ $ram }}" @selected(old('ram_capacity', $existingHosting->ram_capacity ?? 4) == $ram)>
                                                {{ $ram }} GB
                                            </option>
                                        @endforeach
                                    </x-form.select>
                                    <x-form.input-error :messages="$errors->get('ram_capacity')" />
                                </x-form.fieldset>

                                <x-form.fieldset label="{{ __('Storage Capacity') }}">
                                    <x-form.select name="storage_capacity">
                                        @foreach ($hostingMetadata['storage_capacities'] as $storage)
                                            <option value="{{ $storage }}" @selected(old('storage_capacity', $existingHosting->storage_capacity ?? 50) == $storage)>
                                                {{ $storage }} GB
                                            </option>
                                        @endforeach
                                    </x-form.select>
                                    <x-form.input-error :messages="$errors->get('storage_capacity')" />
                                </x-form.fieldset>

                                <x-form.fieldset label="{{ __('Bandwidth') }}">
                                    <x-form.select name="bandwidth_capacity">
                                        @foreach ($hostingMetadata['bandwidth_capacities'] as $bandwidth)
                                            <option value="{{ $bandwidth }}" @selected(old('bandwidth_capacity', $existingHosting->bandwidth_capacity ?? 1000) == $bandwidth)>
                                                {{ $bandwidth >= 1000 ? $bandwidth / 1000 . ' TB' : $bandwidth . ' GB' }}
                                            </option>
                                        @endforeach
                                    </x-form.select>
                                    <x-form.input-description field="bandwidth_capacity"
                                        value="{{ __('Kuota per bulan') }}" />
                                    <x-form.input-error :messages="$errors->get('bandwidth_capacity')" />
                                </x-form.fieldset>
                            </div>

                            {{-- surat permohonan --}}
                            <x-form.fieldset label="{{ __('Surat Permohonan (PDF)') }}">
                                <x-form.file-input id="surat_permohonan" name="surat_permohonan" accept=".pdf" />
                                {{-- Tampilkan surat yang sudah ada menggunakan komponen standar --}}
                                <x-form.current-file :document="$existingHosting?->document" />
                                <x-form.input-error :messages="$errors->get('surat_permohonan')" />
                                <x-form.input-description field="surat_permohonan"
                                    value="{{ __('Kosongkan jika tidak ingin mengubah surat. Ukuran maksimal 5 MB.') }}" />
                            </x-form.fieldset>

                            <x-form.fieldset label="{{ __('Catatan Tambahan') }}">
                                <x-form.textarea name="hosting_notes" rows="6"
                                    placeholder="{{ __('Kebutuhan spesifik lainnya...') }}">
                                    {{ old('hosting_notes', $existingHosting->notes ?? '') }}
                                </x-form.textarea>
                                <x-form.input-error :messages="$errors->get('hosting_notes')" />
                            </x-form.fieldset>
                        </div>

                        <div id="btn-section-hosting"
                            class="hidden items-center justify-end gap-4 mt-6 border-t border-base-200 dark:border-base-content/10 pt-6">
                            <x-button.ghost href="{{ $backUrl ?? route('pse.index') }}">
                                {{ __('Batal') }}
                            </x-button.ghost>
                            <x-button.primary>
                                {{ __('Perbarui') }}
                            </x-button.primary>
                        </div>
                    </x-ui.card>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
