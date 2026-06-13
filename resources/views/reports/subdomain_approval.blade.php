@extends('layouts.pdf')

@section('title', 'Dokumen Subdomain - ' . ($subdomain->pse->system_name ?? 'Sistem'))

@section('content')
    <div class="content">
        <table class="information-letter">
            <tr>
                <td valign="top" style="width: 60%;">
                    <table>
                        <tr>
                            <td>Nomor</td>
                            <td>:</td>
                            <td>B- &nbsp; &nbsp; /DISKOMINFO/{{ date('Y') }}</td>
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
                            <td><strong>Persetujuan Layanan Subdomain</strong></td>
                        </tr>
                    </table>
                </td>
                <td valign="top" align="right"
                    style="text-align: right; vertical-align: top; padding-top: 8px; white-space: nowrap;">
                    <p style="margin: 0; line-height: 1;">Batam,
                        {{ format_date_indo($subdomain->verificationHistories->last()->created_at ?? now()) }}</p>
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
                        <td>{{ $subdomain->pse->system_name ?? 'Sistem' }}</td>
                    </tr>
                    <tr>
                        <td>Nama Subdomain</td>
                        <td>:</td>
                        <td><strong>{{ $subdomain->subdomain_name }}.{{ config('app.domain_suffix') }}</strong></td>
                    </tr>
                    <tr>
                        <td>OPD</td>
                        <td>:</td>
                        <td>{{ $subdomain->pse->opd->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Nama Petugas</td>
                        <td>:</td>
                        <td>{{ $subdomain->user->name ?? 'Petugas' }}</td>
                    </tr>
                    <tr>
                        <td>Tipe Pengajuan</td>
                        <td>:</td>
                        <td>{{ $subdomain->request_type ?? 'Tipe Pengajuan' }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Ajuan</td>
                        <td>:</td>
                        <td>{{ format_date_indo($subdomain->created_at) }}</td>
                    </tr>
                </table>
            </div>
            <div class="table-info">
                <h3>Penanggung Jawab</h3>
                <table>
                    <tr>
                        <td>Nama PIC</td>
                        <td>:</td>
                        <td>{{ $subdomain->pse->pic_name ?? 'PIC' }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Telepon</td>
                        <td>:</td>
                        <td>{{ $subdomain->pse->pic_phone ?? 'Telepon' }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td>{{ $subdomain->pse->pic_email ?? 'Email' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
