@section('title', __('Tambah'))
@section('section', __('Subdomain'))

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <x-ui.heading>
                {{ __('Tambah Subdomain') }}
            </x-ui.heading>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <x-ui.alert-session />
            <x-ui.card :title="__('Formulir Pengajuan')">
                <form action="{{ route('subdomain.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf

                    <x-ui.section-divider :spacing="false" class="text-secondary dark:text-accent">
                        {{ __('Informasi Pengajuan') }}
                    </x-ui.section-divider>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <x-form.fieldset label="{{ __('PSE/Nama Sistem') }}">
                            <x-form.select name="pse_id" :value="old('pse_id')">
                                <option value="" disabled selected>
                                    {{ __('Pilih PSE') }}
                                </option>
                                @forelse ($pses as $pse)
                                    <option value="{{ $pse->id }}"
                                        {{ old('pse_id') == $pse->id ? 'selected' : '' }}>
                                        {{ $pse->system_name }}
                                    </option>
                                @empty
                                    <option value="" disabled>
                                        {{ __('Tidak ada PSE tersedia') }}
                                    </option>
                                @endforelse
                            </x-form.select>
                            <x-form.input-error :messages="$errors->get('pse_id')" />
                            <x-form.input-description field="pse_id"
                                value="{{ __('Pilih PSE/Sistem yang akan digunakan untuk subdomain ini') }}" />
                        </x-form.fieldset>

                        <x-form.fieldset label="{{ __('Tipe Pengajuan') }}">
                            <x-form.select name="request_type" :value="old('request_type')">
                                <option value="" disabled selected>
                                    {{ __('Pilih tipe pengajuan') }}
                                </option>
                                @foreach ($requestTypes as $key => $label)
                                    <option value="{{ $key }}"
                                        {{ old('request_type') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </x-form.select>
                            <x-form.input-error :messages="$errors->get('request_type')" />
                            <x-form.input-description field="request_type"
                                value="{{ __('Pilih jenis pengajuan subdomain yang sesuai dengan kebutuhan Anda') }}" />
                        </x-form.fieldset>

                        <x-form.fieldset label="{{ __('Nama Subdomain') }}">
                            <x-form.text-input name="subdomain_name" :value="old('subdomain_name')"
                                placeholder="{{ __('Contoh: api-portal, admin, puskeswan-batam') }}" />
                            <x-form.input-error :messages="$errors->get('subdomain_name')" />
                            <x-form.input-description field="subdomain_name"
                                value="{{ __('Hanya nama subdomain (huruf kecil, angka, dan dash).') }}" />
                        </x-form.fieldset>
                    </div>

                    <x-ui.section-divider class="text-secondary dark:text-accent">
                        {{ __('Dokumen Pendukung') }}
                    </x-ui.section-divider>

                    <div class="grid grid-cols-1 gap-4">
                        <x-form.fieldset label="{{ __('Surat Permohonan (PDF)') }}">
                            <x-form.file-input id="surat_permohonan" name="surat_permohonan" accept=".pdf" />
                            <x-form.input-error :messages="$errors->get('surat_permohonan')" />
                            <x-form.input-description field="surat_permohonan"
                                value="{{ __('Ukuran maksimal 5 MB. Wajib diupload sebelum mengajukan.') }}" />
                        </x-form.fieldset>
                    </div>

                    <div
                        class="flex items-center justify-end gap-4 pt-4 border-t border-base-200 dark:border-base-content/10">
                        <x-button.ghost href="{{ route('subdomain.index') }}">
                            {{ __('Batal') }}
                        </x-button.ghost>
                        <x-button.primary>
                            {{ __('Simpan') }}
                        </x-button.primary>
                    </div>
                </form>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
