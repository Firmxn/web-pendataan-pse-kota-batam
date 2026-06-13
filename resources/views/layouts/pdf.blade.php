<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dokumen')</title>
    <style>
        @page {
            margin: 1.5cm;
        }

        body {
            font-family: sans-serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            margin: 0;
        }

        /* Kop Surat Standar */
        .header {
            text-align: center;
        }

        .header table {
            width: 100%;
            padding-bottom: 10px;
        }

        .header-logo {
            width: 15%;
            vertical-align: middle;
            text-align: center;
        }

        .header-text {
            width: 85%;
            text-align: center;
            vertical-align: middle;
            padding-right: 15%;
            box-sizing: border-box;
            margin: 0;
        }

        .header-instansi {
            font-size: 14pt;
            font-family: Arial, sans-serif;
            margin: 0;
            line-height: 1.2;
        }

        .header-unit {
            font-size: 16pt;
            font-weight: bold;
            font-family: Arial, sans-serif;
            margin: 0;
            line-height: 1.2;
        }

        .header-address {
            font-size: 10pt;
            font-family: Arial, sans-serif;
            margin: 2px 0;
            line-height: 1.1;
        }

        .border-header-1 {
            border-top: 3px solid #000;
            margin-bottom: 1px;
        }

        .border-header-2 {
            border-top: 1px solid #000;
            margin-top: 0;
            margin-bottom: 20px;
        }

        /* Isi Konten */
        .content {
            text-align: justify;
            margin: 0 0.5cm;
            font-size: 11pt;
        }

        .information-letter {
            width: 100%;
            margin-bottom: 20px;
        }

        .information-letter td:first-child {
            width: 80px;
        }

        /* Kolom separator ":" */
        .information-letter td:nth-child(2) {
            width: 20px;
            text-align: center;
        }

        /* Area Tanda Tangan */
        .signature {
            margin-top: 50px;
            float: right;
            width: 45%;
            text-align: center;
        }

        .signature-name {
            margin-top: 70px;
            font-weight: bold;
            text-decoration: underline;
        }

        /* Tabel Info (Key-Value) */
        .table-info {
            margin-bottom: 20px;
        }

        .table-info h3 {
            font-size: 12pt;
            font-weight: bold;
            margin: 0 0 8px 0;
            padding-bottom: 4px;
            border-bottom: 1px solid #333;
        }

        .table-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-info td {
            padding: 4px 0;
            vertical-align: top;
        }

        /* Kolom label - lebar tetap */
        .table-info td:first-child {
            width: 150px;
        }

        /* Kolom separator ":" */
        .table-info td:nth-child(2) {
            width: 20px;
            text-align: center;
        }

        /* Tabel List (Daftar/Data Berulang) */
        .table-list {
            margin-bottom: 20px;
        }

        .table-list h3 {
            font-size: 11pt;
            font-weight: bold;
            margin: 0 0 10px 0;
        }

        .table-list table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt; /* Ukuran font lebih kecil untuk tabel daftar agar pas di halaman */
        }

        .table-list th, .table-list td {
            border: 1px solid #000;
            padding: 6px;
        }

        .table-list th {
            background-color: #f2f2f2;
        }

        /* Utility Page Break */
        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="header">
        <table>
            <tr>
                {{-- Kolom Logo --}}
                <td class="header-logo">
                    <img src="{{ public_path('images/kop.png') }}" style="width: 80px; height: auto;">
                </td>

                {{-- Kolom Teks --}}
                <td class="header-text">
                    <div class="header-instansi">PEMERINTAH KOTA BATAM</div>
                    <div class="header-unit">DINAS KOMUNIKASI DAN INFORMATIKA</div>

                    <div class="header-address">Jalan Engku Putri No. 1 Kode Pos 29464
                        <br>
                        Telepon: (0778) 8073194, Faksimile: (0778) 461349
                        <br>
                        Laman kominfo.batam.go.id, Pos-el kominfo@batam.go.id
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="border-header-1"></div>
    <div class="border-header-2"></div>
    @yield('content')
</body>

</html>
