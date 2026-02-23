<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota Pembayaran #{{ $transaction->id }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; margin: 30px; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { font-size: 18px; margin: 0; color: #1a56db; }
        .header h2 { font-size: 14px; margin: 5px 0; color: #333; }
        .header p { margin: 2px 0; color: #666; font-size: 11px; }
        .info { margin-bottom: 20px; }
        .info-table { width: 100%; }
        .info-table td { padding: 3px 8px; }
        .info-table td.label { font-weight: bold; width: 160px; }
        .items-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .items-table th { background: #1a56db; color: white; padding: 8px; text-align: left; font-size: 11px; }
        .items-table td { padding: 6px 8px; border-bottom: 1px solid #eee; }
        .items-table .total-row { font-weight: bold; border-top: 2px solid #333; }
        .total-box { text-align: right; margin-top: 10px; padding: 10px; background: #f0f4ff; border-radius: 5px; }
        .total-box .amount { font-size: 16px; font-weight: bold; color: #1a56db; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #999; border-top: 1px solid #ddd; padding-top: 10px; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 3px; font-size: 10px; font-weight: bold; }
        .badge-tunai { background: #d1fae5; color: #065f46; }
        .badge-bpjs { background: #dbeafe; color: #1e40af; }
        .badge-transfer { background: #fef3c7; color: #92400e; }
    </style>
</head>
<body>
    <div class="header">
        <h1>POLIBUN APP - KLINIK</h1>
        <h2>NOTA PEMBAYARAN</h2>
        <p>Jl. Klinik Polibun No. 1 | Telp: (021) 123-4567</p>
    </div>

    <div class="info">
        <table class="info-table">
            <tr>
                <td class="label">No. Nota</td>
                <td>: NP-{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Pembayaran</td>
                <td>: {{ $transaction->payment_date->format('d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Metode Pembayaran</td>
                <td>:
                    <span class="badge badge-{{ strtolower($transaction->payment_method) }}">
                        {{ $transaction->payment_method }}
                    </span>
                </td>
            </tr>
            @if($transaction->registration)
            <tr>
                <td class="label">No. Pendaftaran</td>
                <td>: #{{ $transaction->registration->id }}</td>
            </tr>
            <tr>
                <td class="label">Nama Pasien</td>
                <td>: {{ $transaction->registration->patient->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Asuransi</td>
                <td>: {{ $transaction->registration->patient->insurance_type ?? '-' }}
                    {{ $transaction->registration->patient->insurance_number ? '(' . $transaction->registration->patient->insurance_number . ')' : '' }}
                </td>
            </tr>
            @endif
        </table>
    </div>

    <div class="total-box">
        <p>Total Pembayaran:</p>
        <p class="amount">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
    </div>

    <div class="footer">
        <p>Terima kasih atas kunjungan Anda</p>
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>
