@extends('layouts.pdf')

@section('title', 'Laporan Rekapitulasi - ' . $title)

@section('content')
    <div class="content">
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="margin: 0; text-transform: uppercase;">Laporan Rekapitulasi Pelayanan</h2>
            <h3 style="margin: 5px 0; font-weight: normal;">Periode: {{ $period }}</h3>
            @if ($categoryName !== 'Semua')
                <h3 style="margin: 5px 0; font-weight: normal;">Kategori: {{ $categoryName }}</h3>
            @endif
        </div>
        @if (isset($pseData))
            <div class="table-list">
                <h3>Ringkasan Penyelenggara Sistem Elektronik (PSE)</h3>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">No</th>
                            <th style="width: 100%; text-align: left;">Nama Sistem</th>
                            <th style="text-align: left;">OPD</th>
                            <th style="text-align: left;">Nomor Pendataan PSE</th>
                            <th style="width: 100px; text-align: center;">Tanggal Disetujui</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pseData as $index => $item)
                            <tr>
                                <td style="text-align: center;">{{ $index + 1 }}</td>
                                <td>{{ $item->system_name }}</td>
                                <td>{{ $item->opd->name ?? '-' }}</td>
                                <td>{{ $item->registration_number ?? '-' }}</td>
                                <td style="text-align: center;">{{ format_date_indo($item->approved_at) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center;">Tidak ada data pada periode ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
        @if (isset($subdomainData))
            <div class="table-list">
                <h3>Ringkasan Permohonan Subdomain</h3>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">No</th>
                            <th style="width: 220px; text-align: left;">Nama Subdomain</th>
                            <th style="width: 120px; text-align: left;">Nama Sistem</th>
                            <th style="width: 100%; text-align: left;">OPD</th>
                            <th style="width: 100px; text-align: center;">Tanggal Disetujui</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subdomainData as $index => $item)
                            <tr>
                                <td style="text-align: center;">{{ $index + 1 }}</td>
                                <td>{{ $item->subdomain_name }}.{{ config('app.domain_suffix') }}</td>
                                <td>{{ $item->pse->system_name ?? '-' }}</td>
                                <td>{{ $item->pse->opd->name ?? '-' }}</td>
                                <td style="text-align: center;">{{ format_date_indo($item->approved_at) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center;">Tidak ada data pada periode ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
        @if (isset($hostingData))
            <div class="table-list">
                <h3>Ringkasan Permohonan Hosting</h3>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">No</th>
                            <th style="width: 150px; text-align: left;">Nama Sistem</th>
                            <th style="text-align: left;">Jasa Sewa</th>
                            <th style="width: 100%; text-align: left;">OPD</th>
                            <th style="width: 100px; text-align: center;">Tanggal Disetujui</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hostingData as $index => $item)
                            <tr>
                                <td style="text-align: center;">{{ $index + 1 }}</td>
                                <td>{{ $item->pse->system_name ?? '-' }}</td>
                                <td>{{ $item->hosting_type }}</td>
                                <td>{{ $item->pse->opd->name ?? '-' }}</td>
                                <td style="text-align: center;">{{ format_date_indo($item->approved_at) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center;">Tidak ada data pada periode ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif

        <div style="margin-top: 50px;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 60%;"></td>
                    <td style="text-align: center;">
                        <p style="margin-bottom: 60px;">Batam, {{ format_date_indo(now()) }}<br><strong>Verifikator
                                Sistem,</strong></p>
                        <p><strong>{{ Auth::user()->name }}</strong><br>NIP.
                            {{ Auth::user()->nip ?? '..........................' }}</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection
