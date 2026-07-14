@extends('layouts.pdf')

@section('title', 'Dokumen Hosting - ' . ($hosting->pse->system_name ?? 'Sistem'))

@section('content')
    <div class="content">
        <table class="information-letter">
            <tr>
                <td valign="top" style="width: 60%;">
                    <table>
                        <tr>
                            <td>Nomor</td>
                            <td>:</td>
                            <td>....................../DISKOMINFO/{{ date('Y') }}</td>
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
                            <td><strong>Persetujuan Layanan Hosting</strong></td>
                        </tr>
                    </table>
                </td>
                <td valign="top" align="right"
                    style="text-align: right; vertical-align: top; padding-top: 8px; white-space: nowrap;">
                    <p style="margin: 0; line-height: 1;">Batam,
                        {{ format_date_indo($hosting->verificationHistories->last()?->created_at ?? now()) }}</p>
                </td>
            </tr>
        </table>
        <div>
            <div class="table-info">
                <h3>Informasi Umum</h3>
                <table>
                    <tr>
                        <td>Nama Sistem</td>
                        <td>:</td>
                        <td>{{ $hosting->pse->system_name ?? 'Sistem' }}</td>
                    </tr>
                    <tr>
                        <td>OPD</td>
                        <td>:</td>
                        <td>{{ $hosting->pse->opd->name ?? 'OPD' }}</td>
                    </tr>
                    <tr>
                        <td>Nama Petugas</td>
                        <td>:</td>
                        <td>{{ $hosting->user->name ?? 'Petugas' }}</td>
                    </tr>
                    <tr>
                        <td>Tipe Pengajuan</td>
                        <td>:</td>
                        <td>{{ $hosting->request_type ?? 'Tipe Pengajuan' }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Ajuan</td>
                        <td>:</td>
                        <td>{{ $hosting->created_at->format('d F Y') }}</td>
                    </tr>
                </table>
            </div>
            <div class="table-info">
                <h3>Spesifikasi Server</h3>
                <table>
                    <tr>
                        <td>Tipe Hosting</td>
                        <td>:</td>
                        <td>{{ $hosting->hosting_type ?? 'Tipe Hosting' }}</td>
                    </tr>
                    <tr>
                        <td>RAM Capacity</td>
                        <td>:</td>
                        <td>{{ $hosting->ram_capacity ?? 'RAM Capacity' }} GB</td>
                    </tr>
                    <tr>
                        <td>CPU Cores</td>
                        <td>:</td>
                        <td>{{ $hosting->cpu_cores ?? 'CPU Cores' }} Core</td>
                    </tr>
                    <tr>
                        <td>Bandwidth Capacity</td>
                        <td>:</td>
                        <td>{{ $hosting->bandwidth_capacity ?? 'Bandwidth' }} GB / Bulan</td>
                    </tr>
                    <tr>
                        <td>Storage Capacity</td>
                        <td>:</td>
                        <td>{{ $hosting->storage_capacity ?? 'Storage Capacity' }} GB</td>
                    </tr>
                    <tr>
                        <td>Catatan Tambahan</td>
                        <td>:</td>
                        <td>{{ $hosting->notes ?? '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="table-info">
                <h3>Penanggung Jawab</h3>
                <table>
                    <tr>
                        <td>Nama PIC</td>
                        <td>:</td>
                        <td>{{ $hosting->pse->pic_name ?? 'PIC' }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Telepon</td>
                        <td>:</td>
                        <td>{{ $hosting->pse->pic_phone ?? 'Telepon' }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td>{{ $hosting->pse->pic_email ?? 'Email' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
