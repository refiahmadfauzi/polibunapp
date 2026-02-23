<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Medis - {{ $letter->type }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; margin: 40px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 15px; }
        .header h1 { font-size: 18px; margin: 0; color: #1a56db; }
        .header p { margin: 3px 0; color: #666; }
        .content { margin: 20px 0; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 5px 10px; vertical-align: top; }
        .info-table td.label { font-weight: bold; width: 150px; }
        .description { padding: 15px; border: 1px solid #ddd; border-radius: 5px; background: #f9fafb; min-height: 100px; }
        .footer { margin-top: 50px; text-align: right; }
        .footer .sign-area { margin-top: 60px; }
        .type-badge { display: inline-block; padding: 3px 10px; border-radius: 3px; font-size: 11px; font-weight: bold; }
        .type-rujukan { background: #dbeafe; color: #1e40af; }
        .type-sakit { background: #fef3c7; color: #92400e; }
    </style>
</head>
<body>
    <div class="header">
        <h1>POLIBUN APP - KLINIK</h1>
        <p>Jl. Klinik Polibun No. 1</p>
        <p>Telp: (021) 123-4567</p>
    </div>

    <div class="content">
        <h2 style="text-align: center;">
            SURAT
            <span class="type-badge {{ $letter->type === 'Rujukan' ? 'type-rujukan' : 'type-sakit' }}">
                {{ strtoupper($letter->type) }}
            </span>
        </h2>

        <table class="info-table">
            <tr>
                <td class="label">No. Surat</td>
                <td>: SM-{{ str_pad($letter->id, 5, '0', STR_PAD_LEFT) }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal</td>
                <td>: {{ $letter->created_at->format('d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Nama Pasien</td>
                <td>: {{ $letter->patient->name }}</td>
            </tr>
            <tr>
                <td class="label">Jenis Kelamin</td>
                <td>: {{ $letter->patient->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            @if($letter->patient->birth_date)
            <tr>
                <td class="label">Tanggal Lahir</td>
                <td>: {{ $letter->patient->birth_date->format('d F Y') }} ({{ $letter->patient->age }} tahun)</td>
            </tr>
            @endif
            <tr>
                <td class="label">No. Asuransi</td>
                <td>: {{ $letter->patient->insurance_number ?: '-' }} ({{ $letter->patient->insurance_type }})</td>
            </tr>
        </table>

        <p><strong>Keterangan:</strong></p>
        <div class="description">
            {!! $letter->description !!}
        </div>
    </div>

    <div class="footer">
        <p>{{ now()->format('d F Y') }}</p>
        <p>Dokter / Tenaga Medis</p>
        <div class="sign-area">
            <p>( _________________________ )</p>
        </div>
    </div>
</body>
</html>
