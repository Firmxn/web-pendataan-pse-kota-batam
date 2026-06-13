@section('title', __('Manajemen'))
@section('section', __('Edit Profil Petugas'))

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center px-4 sm:px-0">
            <x-ui.heading level="2">{{ __('Edit Data Petugas') }}</x-ui.heading>
            <x-button.ghost href="{{ route('user.index') }}">
                {{ __('Kembali') }}
            </x-button.ghost>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-ui.alert-session />

            <x-ui.card :title="__('Formulir Perubahan Data')">
                <form action="{{ route('user.update', $user) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('patch')

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 gap-y-4">
                        {{-- KOLOM KIRI: DATA DIRI --}}
                        <div class="space-y-4">
                            <x-ui.section-divider :spacing="false" class="text-secondary">
                                {{ __('Data Diri Petugas') }}
                            </x-ui.section-divider>

                            {{-- Nama Lengkap --}}
                            <x-form.fieldset label="{{ __('Nama Lengkap') }}">
                                <x-form.text-input id="name" name="name" type="text" :value="old('name', $user->name)"
                                    required autofocus />
                                <x-form.input-error :messages="$errors->get('name')" />
                            </x-form.fieldset>

                            {{-- Email --}}
                            <x-form.fieldset label="{{ __('Email (Resmi / Batam.go.id)') }}">
                                <x-form.text-input id="email" name="email" type="email" :value="old('email', $user->email)"
                                    required />
                                <x-form.input-error :messages="$errors->get('email')" />
                            </x-form.fieldset>

                            {{-- NIP --}}
                            <x-form.fieldset label="{{ __('NIP') }}">
                                <x-form.text-input id="nip" name="nip" type="number" :value="old('nip', $user->nip)"
                                    required />
                                <x-form.input-error :messages="$errors->get('nip')" />
                            </x-form.fieldset>

                            {{-- Nomor Telepon --}}
                            <x-form.fieldset label="{{ __('Nomor Telepon') }}">
                                <x-form.text-input id="phone" name="phone" type="number" :value="old('phone', $user->phone)"
                                    required />
                                <x-form.input-error :messages="$errors->get('phone')" />
                            </x-form.fieldset>
                        </div>

                        {{-- KOLOM KANAN: OPD / UNIT KERJA --}}
                        <div class="space-y-4">
                            <x-ui.section-divider :spacing="false" class="text-secondary">
                                {{ __('Informasi Instansi') }}
                            </x-ui.section-divider>

                            {{-- OPD --}}
                            <x-form.fieldset label="{{ __('OPD') }}">
                                <x-form.select id="opd_id" name="opd_id" required>
                                    <option value="" disabled>{{ __('Pilih OPD...') }}</option>
                                    @foreach ($opds as $opd)
                                        <option value="{{ $opd->id }}"
                                            {{ old('opd_id', $user->opd_id) == $opd->id ? 'selected' : '' }}>
                                            {{ $opd->name }}
                                        </option>
                                    @endforeach
                                </x-form.select>
                                <x-form.input-error :messages="$errors->get('opd_id')" />
                            </x-form.fieldset>

                            {{-- Jabatan --}}
                            <x-form.fieldset label="{{ __('Jabatan') }}">
                                <x-form.text-input id="position" name="position" type="text" :value="old('position', $user->position)"
                                    required />
                                <x-form.input-error :messages="$errors->get('position')" />
                            </x-form.fieldset>

                            {{-- Unit Kerja --}}
                            <x-form.fieldset label="{{ __('Unit Kerja') }}">
                                <x-form.text-input id="work_unit" name="work_unit" type="text" :value="old('work_unit', $user->work_unit)"
                                    required />
                                <x-form.input-error :messages="$errors->get('work_unit')" />
                            </x-form.fieldset>

                            {{-- Telepon Unit Kerja --}}
                            <x-form.fieldset label="{{ __('Telepon Unit Kerja') }}">
                                <x-form.text-input id="work_unit_phone" name="work_unit_phone" type="number"
                                    :value="old('work_unit_phone', $user->work_unit_phone)" required />
                                <x-form.input-error :messages="$errors->get('work_unit_phone')" />
                            </x-form.fieldset>
                        </div>
                    </div>

                    {{-- Surat Tugas --}}
                    <x-form.fieldset label="{{ __('Surat Tugas (PDF)') }}">
                        <x-form.file-input id="assignment_letter" name="assignment_letter" accept="application/pdf" />
                        <x-form.input-error :messages="$errors->get('assignment_letter')" />
                        <x-form.input-description field="assignment_letter"
                            value="{{ __('Biarkan kosong jika tidak ingin mengubah surat tugas. Maksimal 5 MB.') }}" />
                        <x-form.current-file :document="$user->document" />
                    </x-form.fieldset>

                    <div
                        class="flex items-center justify-end gap-4 mt-6 border-t border-base-200 dark:border-base-content/10 pt-6">
                        <x-button.ghost href="{{ route('user.index') }}">
                            {{ __('Batal') }}
                        </x-button.ghost>
                        <x-button.primary type="submit">
                            {{ __('Simpan Perubahan') }}
                        </x-button.primary>
                    </div>
                </form>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
