<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $rental->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #fff;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            border-bottom: 3px solid #3b82f6;
            padding-bottom: 20px;
        }

        .company-info {
            flex: 1;
        }

        .company-name {
            font-size: 28px;
            font-weight: bold;
            color: #3b82f6;
            margin-bottom: 5px;
        }

        .company-details {
            font-size: 14px;
            color: #666;
            line-height: 1.4;
        }

        .invoice-info {
            text-align: right;
        }

        .invoice-title {
            font-size: 32px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 10px;
        }

        .invoice-number {
            font-size: 18px;
            color: #666;
            margin-bottom: 5px;
        }

        .invoice-date {
            font-size: 14px;
            color: #666;
        }

        .client-info {
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .client-title {
            font-size: 16px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 10px;
        }

        .client-details {
            font-size: 14px;
            color: #4b5563;
        }

        .rental-details {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 2px solid #e5e7eb;
        }

        .rental-item {
            background-color: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .item-header {
            background-color: #f9fafb;
            padding: 15px 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .item-name {
            font-size: 16px;
            font-weight: bold;
            color: #1f2937;
        }

        .item-details {
            padding: 20px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .detail-label {
            color: #6b7280;
            font-weight: 500;
        }

        .detail-value {
            color: #1f2937;
            font-weight: 500;
        }

        .calculation-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        .calculation-table th,
        .calculation-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .calculation-table th {
            background-color: #f9fafb;
            font-weight: bold;
            color: #1f2937;
        }

        .calculation-table .total-row {
            background-color: #3b82f6;
            color: white;
            font-weight: bold;
            font-size: 16px;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-disetujui {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .status-dipinjam {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-dikembalikan {
            background-color: #f3f4f6;
            color: #374151;
        }

        .status-dibatalkan {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
        }

        .footer-text {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 10px;
        }

        .terms {
            margin-top: 30px;
            padding: 20px;
            background-color: #f8fafc;
            border-radius: 8px;
        }

        .terms-title {
            font-size: 14px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 10px;
        }

        .terms-list {
            font-size: 12px;
            color: #4b5563;
            line-height: 1.5;
        }

        .terms-list li {
            margin-bottom: 5px;
        }

        @media print {
            body {
                font-size: 12px;
            }

            .container {
                padding: 20px 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <div class="company-name">PinjemTent</div>
                <div class="company-details">
                    Layanan Penyewaan Tenda & Alat Camping<br>
                    Jl. Contoh No. 123, Jakarta<br>
                    Telp: +62 123 456 7890<br>
                    Email: info@pinjemtent.com
                </div>
            </div>
            <div class="invoice-info">
                <div class="invoice-title">INVOICE</div>
                <div class="invoice-number">#{{ str_pad($rental->id, 6, '0', STR_PAD_LEFT) }}</div>
                <div class="invoice-date">{{ $rental->created_at->format('d F Y') }}</div>
            </div>
        </div>

        <!-- Client Info -->
        <div class="client-info">
            <div class="client-title">Informasi Penyewa</div>
            <div class="client-details">
                <strong>{{ $rental->user->name }}</strong><br>
                Email: {{ $rental->user->email }}<br>
                @if($rental->user->phone)
                    Telp: {{ $rental->user->phone }}<br>
                @endif
                Status: <span class="status-badge status-{{ $rental->status }}">{{ ucfirst($rental->status) }}</span>
            </div>
        </div>

        <!-- Rental Details -->
        <div class="rental-details">
            <div class="section-title">Detail Penyewaan</div>

            <div class="rental-item">
                <div class="item-header">
                    <div class="item-name">{{ $rental->unit->nama_unit }}</div>
                </div>
                <div class="item-details">
                    <div class="detail-row">
                        <span class="detail-label">Merek:</span>
                        <span class="detail-value">{{ $rental->unit->merek }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Kondisi:</span>
                        <span class="detail-value">{{ $rental->unit->kondisi }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Kategori:</span>
                        <span class="detail-value">
                            @foreach($rental->unit->kategoris as $kategori)
                                {{ $kategori->nama_kategori }}@if(!$loop->last), @endif
                            @endforeach
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tanggal Peminjaman:</span>
                        <span class="detail-value">{{ \Carbon\Carbon::parse($rental->tanggal_pinjam)->format('d F Y') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tanggal Pengembalian:</span>
                        <span class="detail-value">{{ \Carbon\Carbon::parse($rental->tanggal_kembali_rencana)->format('d F Y') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Durasi:</span>
                        <span class="detail-value">
                            {{ \Carbon\Carbon::parse($rental->tanggal_pinjam)->diffInDays(\Carbon\Carbon::parse($rental->tanggal_kembali_rencana)) + 1 }} hari
                        </span>
                    </div>
                    @if($rental->keterangan)
                        <div class="detail-row">
                            <span class="detail-label">Keterangan:</span>
                            <span class="detail-value">{{ $rental->keterangan }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Calculation -->
        <table class="calculation-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Jumlah</th>
                    <th>Harga per Hari</th>
                    <th>Durasi</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $rental->unit->nama_unit }}</td>
                    <td>{{ $rental->jumlah }} unit</td>
                    <td>Rp {{ number_format($rental->unit->harga_sewa_per_hari, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($rental->tanggal_pinjam)->diffInDays(\Carbon\Carbon::parse($rental->tanggal_kembali_rencana)) + 1 }} hari</td>
                    <td>Rp {{ number_format($rental->harga_sewa_total, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="4">TOTAL</td>
                    <td>Rp {{ number_format($rental->harga_sewa_total, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Terms & Conditions -->
        <div class="terms">
            <div class="terms-title">Syarat & Ketentuan</div>
            <ul class="terms-list">
                <li>Penyewa wajib menjaga dan merawat unit yang disewa dengan baik</li>
                <li>Kerusakan atau kehilangan unit menjadi tanggung jawab penyewa</li>
                <li>Pengembalian unit harus sesuai dengan jadwal yang telah ditentukan</li>
                <li>Keterlambatan pengembalian akan dikenakan denda sesuai ketentuan</li>
                <li>Pembatalan penyewaan hanya dapat dilakukan maksimal H-1 sebelum tanggal peminjaman</li>
                <li>Unit yang dikembalikan harus dalam kondisi bersih dan sama seperti saat dipinjam</li>
                <li>PinjemTent berhak menolak penyewaan tanpa memberikan alasan tertentu</li>
            </ul>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-text">
                Terima kasih telah menggunakan layanan PinjemTent.<br>
                Invoice ini digenerate secara otomatis pada {{ now()->format('d F Y, H:i') }}
            </div>
            <div class="footer-text">
                <strong>Hubungi kami:</strong> info@pinjemtent.com | +62 123 456 7890
            </div>
        </div>
    </div>
</body>
</html>
