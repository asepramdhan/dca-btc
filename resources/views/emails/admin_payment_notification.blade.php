<!DOCTYPE html>
<html>
<head>
  <title>Notifikasi Pembayaran Baru</title>
</head>
<body>
  <h1>Pembayaran Baru Diterima! (Menunggu Konfirmasi)</h1>
  <p>Halo Administrator,</p>
  <p>Seorang pengguna telah melakukan pembayaran dan membutuhkan konfirmasi.</p>
  <p>Detail Transaksi:</p>
  <ul>
    <li><strong>User:</strong> {{ $transaction->user->name }} ({{ $transaction->user->email }})</li>
    <li><strong>Order ID:</strong> {{ $transaction->order_id }}</li>
    <li><strong>Paket:</strong> {{ $transaction->package_name }}</li>
    <li><strong>Jumlah Pembayaran:</strong> Rp {{ number_format($transaction->amount, 0, ',', '.') }}</li>
    <li><strong>Metode Pembayaran:</strong> {{ ucfirst($transaction->payment_type) }}</li>
    <li><strong>Status Transaksi:</strong> {{ ucfirst($transaction->status) }}</li>
    <li><strong>Waktu Pembayaran (estimasi):</strong> {{ \Carbon\Carbon::parse($transaction->created_at)->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s') }} WIB</li>
  </ul>
  <p>Silakan masuk ke panel admin Anda untuk memverifikasi pembayaran ini dan mengaktifkan akun premium pengguna.</p>
  <p>Terima kasih,</p>
  <p>Sistem Notifikasi Anda</p>
</body>
</html>
