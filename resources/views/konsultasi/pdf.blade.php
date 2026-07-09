<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hasil Diagnosis - {{ $riwayat->nama_pasien }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 13px;
            line-height: 1.6;
            color: #334155;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header .logo {
            font-size: 28px;
            font-weight: 900;
            color: #1e293b;
            letter-spacing: -0.5px;
            margin: 0;
        }
        .header .logo span {
            color: #2563eb;
        }
        .header p {
            margin: 5px 0 0;
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1e40af;
            border-bottom: 1px solid #bfdbfe;
            padding-bottom: 5px;
            margin-top: 25px;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .info-table {
            margin-bottom: 25px;
        }
        .info-table td {
            padding: 6px 0;
            vertical-align: top;
        }
        .info-table .label {
            width: 150px;
            font-weight: bold;
            color: #475569;
        }
        
        .gejala-table {
            margin-bottom: 30px;
            border: 1px solid #e2e8f0;
        }
        .gejala-table th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: bold;
            text-align: left;
            padding: 10px 12px;
            border-bottom: 1px solid #e2e8f0;
        }
        .gejala-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
        }
        .badge {
            display: inline-block;
            background-color: #f1f5f9;
            color: #64748b;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
        }
        .condition-text {
            font-weight: bold;
            color: #2563eb;
        }
        
        /* Hasil Box */
        .hasil-container {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        .hasil-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            position: relative;
        }
        .hasil-box.cf { border-left: 5px solid #2563eb; }
        .hasil-box.ds { border-left: 5px solid #0d9488; }
        
        .percentage-circle {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: white;
            border: 2px solid #e2e8f0;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            text-align: center;
            line-height: 60px;
            font-size: 18px;
            font-weight: bold;
        }
        .cf .percentage-circle { color: #2563eb; border-color: #bfdbfe; }
        .ds .percentage-circle { color: #0d9488; border-color: #99f6e4; }
        
        .penyakit-nama {
            font-size: 20px;
            font-weight: bold;
            margin: 0 0 5px 0;
            width: 80%;
        }
        .cf .penyakit-nama { color: #1e40af; }
        .ds .penyakit-nama { color: #115e59; }
        
        .metode-label {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 15px;
            display: block;
        }
        
        .desc-box {
            background-color: white;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            margin-bottom: 12px;
        }
        .solusi-box {
            background-color: #eff6ff;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #bfdbfe;
        }
        .ds .solusi-box { background-color: #f0fdfa; border-color: #a7f3d0; }
        
        h4 { margin: 0 0 5px 0; font-size: 13px; }
        .cf h4 { color: #1e40af; }
        .ds h4 { color: #115e59; }
        
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px dashed #cbd5e1;
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

    @php
        function getKondisiText($value) {
            $val = floatval($value);
            if ($val >= 1.0) return 'Sangat Yakin / Pasti';
            if ($val >= 0.8) return 'Yakin / Hampir Pasti';
            if ($val >= 0.6) return 'Cukup Yakin';
            if ($val >= 0.4) return 'Sedikit Yakin / Ragu';
            return 'Sangat Ragu';
        }
    @endphp

    <div class="header">
        <h1 class="logo">Pak<span>Ginjal</span></h1>
        <p>Laporan Pemeriksaan & Deteksi Dini Penyakit Ginjal</p>
    </div>

    <div class="section-title">Informasi Pasien</div>
    <table class="info-table">
        <tr>
            <td class="label">No. Pemeriksaan</td>
            <td>: #{{ str_pad($riwayat->id, 5, '0', STR_PAD_LEFT) }}</td>
            <td class="label">Tanggal Keluar</td>
            <td>: {{ $riwayat->created_at->format('d F Y, H:i') }}</td>
        </tr>
        <tr>
            <td class="label">Nama Pasien</td>
            <td>: {{ $riwayat->nama_pasien }}</td>
            <td class="label">TTL</td>
            <td>: {{ $riwayat->tempat_lahir ?: '-' }}, {{ $riwayat->tanggal_lahir ? \Carbon\Carbon::parse($riwayat->tanggal_lahir)->format('d F Y') : '-' }}</td>
        </tr>
    </table>

    <div class="section-title">Keluhan & Gejala yang Dialami</div>
    <table class="gejala-table">
        <thead>
            <tr>
                <th width="10%">No.</th>
                <th width="50%">Keluhan / Gejala</th>
                <th width="40%">Tingkat Keyakinan Pasien</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($gejalaList as $g)
            <tr>
                <td style="text-align: center; color: #64748b;">{{ $no++ }}</td>
                <td>
                    {{ $g->nama }}<br>
                    <span class="badge">{{ $g->kode }}</span>
                </td>
                <td>
                    <span class="condition-text">{{ getKondisiText($gejalaUser[$g->id]) }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Hasil Pemeriksaan Sistem</div>
    
    <p style="margin-bottom: 15px; color: #475569;">Berdasarkan keluhan yang Anda rasakan, sistem pakar kami telah menganalisis kondisi Anda menggunakan dua pendekatan kecerdasan buatan. Berikut adalah hasil kesimpulan yang diperoleh:</p>

    <!-- Hasil CF -->
    <div class="hasil-container">
        <div class="hasil-box cf">
            <div class="percentage-circle">
                {{ round($riwayat->nilai_cf * 100, 1) }}%
            </div>
            
            <span class="metode-label">Analisis 1: Certainty Factor</span>
            
            @if($penyakitCf)
                <h2 class="penyakit-nama">{{ $penyakitCf->nama }}</h2>
                
                <div class="desc-box">
                    <h4>Informasi Penyakit:</h4>
                    {{ $penyakitCf->deskripsi ?: 'Tidak ada deskripsi.' }}
                </div>
                
                <div class="solusi-box">
                    <h4>Rekomendasi Tindakan / Solusi:</h4>
                    {{ $penyakitCf->solusi ?: 'Silakan konsultasikan dengan dokter Anda.' }}
                </div>
            @else
                <h2 class="penyakit-nama" style="color: #64748b;">Tidak Terdeteksi</h2>
                <p>Sistem tidak dapat mengidentifikasi penyakit ginjal berdasarkan gejala yang Anda masukkan (Tingkat kepastian 0%).</p>
            @endif
        </div>
    </div>

    <!-- Hasil DS -->
    <div class="hasil-container">
        <div class="hasil-box ds">
            <div class="percentage-circle">
                {{ round($riwayat->nilai_ds * 100, 1) }}%
            </div>
            
            <span class="metode-label">Analisis 2: Dempster-Shafer</span>
            
            @if($penyakitDs)
                <h2 class="penyakit-nama">{{ $penyakitDs->nama }}</h2>
                
                <div class="desc-box">
                    <h4>Informasi Penyakit:</h4>
                    {{ $penyakitDs->deskripsi ?: 'Tidak ada deskripsi.' }}
                </div>
                
                <div class="solusi-box">
                    <h4>Rekomendasi Tindakan / Solusi:</h4>
                    {{ $penyakitDs->solusi ?: 'Silakan konsultasikan dengan dokter Anda.' }}
                </div>
            @else
                <h2 class="penyakit-nama" style="color: #64748b;">Tidak Terdeteksi</h2>
                <p>Sistem tidak dapat mengidentifikasi penyakit ginjal berdasarkan gejala yang Anda masukkan (Tingkat kepastian 0%).</p>
            @endif
        </div>
    </div>

    <div class="footer">
        <strong>Peringatan Medis Penting:</strong> Laporan ini dihasilkan secara otomatis oleh algoritma sistem pakar dan hanya ditujukan sebagai alat bantu deteksi dini <em>(screening)</em>. Hasil dari aplikasi ini <strong>tidak boleh</strong> dijadikan sebagai diagnosis akhir atau pengganti dari konsultasi, pemeriksaan fisik, dan tes laboratorium yang dilakukan oleh dokter ahli nefrologi atau tenaga kesehatan profesional.<br><br>
        &copy; {{ date('Y') }} Aplikasi PakGinjal. Dicetak pada {{ date('d/m/Y H:i:s') }}.
    </div>

</body>
</html>
