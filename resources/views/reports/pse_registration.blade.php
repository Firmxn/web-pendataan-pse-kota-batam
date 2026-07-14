@extends('layouts.pdf')

@section('title', 'Tanda Data PSE - ' . ($pse->system_name ?? 'Sistem'))

@section('content')
    <div class="content">
        <table class="information-letter">
            <tr>
                <td valign="top" style="width: 60%;">
                    <table>
                        <tr>
                            <td>Nomor</td>
                            <td>:</td>
                            <td>{{ $pse->registration_number }}</td>
                        </tr>
                        <tr>
                            <td>Sifat</td>
                            <td>:</td>
                            <td>Biasa</td>
                        </tr>
                        <tr>
                            <td>Lampiran</td>
                            <td>:</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>Hal</td>
                            <td>:</td>
                            <td><strong>Tanda Data Penyelenggara Sistem Elektronik</strong></td>
                        </tr>
                    </table>
                </td>
                <td valign="top" align="right"
                    style="text-align: right; vertical-align: top; padding-top: 8px; white-space: nowrap;">
                    <p style="margin: 0; line-height: 1;">Batam,
                        {{ format_date_indo($pse->verificationHistories->last()?->created_at ?? now()) }}</p>
                </td>
            </tr>
        </table>
        <div>
            {{-- Informasi Sistem --}}
            <div class="table-info">
                <h3>Informasi Sistem</h3>
                <table>
                    {{-- <tr>
                        <td>Nomor Pendataan PSE</td>
                        <td>:</td>
                        <td><strong>{{ $pse->registration_number ?? '-' }}</strong></td>
                    </tr> --}}
                    <tr>
                        <td>Nama Sistem</td>
                        <td>:</td>
                        <td>{{ $pse->system_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Sektor</td>
                        <td>:</td>
                        <td>{{ $pse->sector_label ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td valign="top">Daftar Subdomain</td>
                        <td valign="top">:</td>
                        <td>
                            @forelse ($pse->subdomainRequests as $sub)
                                <div>
                                    {{ $sub->subdomain_name }}.{{ config('app.domain_suffix') }}
                                    @if ($sub->is_primary)
                                        <em> [Utama]</em>
                                    @endif
                                </div>
                            @empty
                                -
                            @endforelse
                        </td>
                    </tr>
                    <tr>
                        <td>Deskripsi</td>
                        <td>:</td>
                        <td>{{ $pse->description ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Ajuan</td>
                        <td>:</td>
                        <td>{{ format_date_indo($pse->created_at) }}</td>
                    </tr>
                </table>
            </div>



            {{-- Klasifikasi Data --}}
            <div class="table-info">
                <h3>Klasifikasi Data</h3>
                <table>
                    <tr>
                        <td>Kategori Risiko</td>
                        <td>:</td>
                        <td>{{ ucwords($pse->risk_category ?? '-') }}</td>
                    </tr>
                    <tr>
                        <td>Klasifikasi Data</td>
                        <td>:</td>
                        <td>{{ ucwords($pse->data_classification ?? '-') }}</td>
                    </tr>
                    <tr>
                        <td>Info Data Pribadi</td>
                        <td>:</td>
                        <td>{{ $pse->private_data_info ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Lokasi Penyimpanan</td>
                        <td>:</td>
                        <td>{{ $pse->storage_location_label ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            {{-- Informasi OPD --}}
            <div class="table-info">
                <h3>Informasi OPD</h3>
                <table>
                    <tr>
                        <td>Nama OPD</td>
                        <td>:</td>
                        <td>{{ $pse->opd->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Tipe</td>
                        <td>:</td>
                        <td>{{ $pse->opd->type ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Email Resmi</td>
                        <td>:</td>
                        <td>{{ $pse->opd->email ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            {{-- Informasi Petugas --}}
            <div class="table-info">
                <h3>Informasi Petugas</h3>
                <table>
                    <tr>
                        <td>Nama Petugas</td>
                        <td>:</td>
                        <td>{{ $pse->user->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>NIP</td>
                        <td>:</td>
                        <td>{{ $pse->user->nip ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td>{{ $pse->user->position ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>:</td>
                        <td>{{ ucfirst($pse->user->status ?? '-') }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td>{{ $pse->user->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Telepon</td>
                        <td>:</td>
                        <td>{{ $pse->user->formatted_phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Unit Kerja</td>
                        <td>:</td>
                        <td>{{ $pse->user->work_unit ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Telepon Unit Kerja</td>
                        <td>:</td>
                        <td>{{ $pse->user->formatted_work_unit_phone ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            {{-- Penanggung Jawab --}}
            <div class="table-info">
                <h3>Penanggung Jawab</h3>
                <table>
                    <tr>
                        <td>Nama PIC</td>
                        <td>:</td>
                        <td>{{ $pse->pic_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Telepon</td>
                        <td>:</td>
                        <td>{{ $pse->pic_phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td>{{ $pse->pic_email ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
