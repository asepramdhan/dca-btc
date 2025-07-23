<?php

namespace App\Livewire;

use App\Models\Daily;
use App\Models\Dca;
use App\Models\Emergency;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Dashboard extends Component
{
    public $headerInvestasis = [
        ['key' => 'id', 'label' => '#', 'class' => 'bg-error/20 w-1'],
        ['key' => 'created_at', 'label' => 'Tanggal'],
        ['key' => 'amount', 'label' => 'Jumlah (Rp)'],
        ['key' => 'price', 'label' => 'Harga Beli/Jual'],
        ['key' => 'fee', 'label' => 'Fee', 'class' => 'hidden sm:table-cell'],
        ['key' => 'quantity', 'label' => 'Jumlah BTC'],
        ['key' => 'exchange_id', 'label' => 'Exchange'],
        ['key' => 'type', 'label' => 'Tipe', 'class' => 'hidden sm:table-cell'],
        ['key' => 'description', 'label' => 'Keterangan', 'class' => 'hidden sm:table-cell'],
    ];
    public $headerDanaDarurats = [
        ['key' => 'id', 'label' => '#', 'class' => 'bg-error/20 w-1'],
        ['key' => 'created_at', 'label' => 'Tanggal'],
        ['key' => 'amount', 'label' => 'Jumlah'],
        ['key' => 'type', 'label' => 'Tipe', 'class' => 'hidden sm:table-cell'],
        ['key' => 'description', 'label' => 'Keterangan'],
    ];
    public $headerDanaHarians = [
        ['key' => 'id', 'label' => '#', 'class' => 'bg-error/20 w-1'],
        ['key' => 'created_at', 'label' => 'Tanggal'],
        ['key' => 'amount', 'label' => 'Jumlah'],
        ['key' => 'type', 'label' => 'Tipe', 'class' => 'hidden sm:table-cell'],
        ['key' => 'description', 'label' => 'Keterangan', 'class' => 'hidden sm:table-cell'],
    ];
    public ?int $bitcoinIdr = null;
    public $danaDaruratSum = 0;
    public $danaDaruratColor = 'text-error';
    public $idealEmergency = 0;
    public $danaHarianSum = 0;
    public $danaHarianColor = 'text-error';
    public $dailyAverage = 0;
    public $investasiSum = 0;
    public $investasiColor = 'text-slate-400';
    public $bitcoinSum = 0;
    public $portofolioSum = 0;
    public $portofolioColor = 'text-error';
    public $portofolioTooltip = 'Bad Job...';
    public $selisihSum = 0;
    public $selisihColor = 'text-error';
    public $persentaseSum = 0;
    public array $myChart = [];

    // Lifecycle mount: load data saat komponen diinisialisasi
    public function mount(): void
    {
        $this->loadDashboardData();
    }
    // Method untuk update data dashboard (dipanggil via polling)
    public function updateDashboard(): void
    {
        $this->loadDashboardData();
    }
    // Method utama untuk mengambil dan menghitung data dashboard
    private function loadDashboardData(): void
    {
        // Ambil harga Bitcoin dalam IDR dari CoinGecko dan cache selama 5 menit
        $this->bitcoinIdr = Cache::remember(
            'btc-idr-price',
            300,
            fn() =>
            (int) (Http::get('https://api.coingecko.com/api/v3/simple/price', [
                'ids' => 'bitcoin',
                'vs_currencies' => 'idr',
            ])['bitcoin']['idr'] ?? 0)
        );
        // Simpan ID user saat ini agar tidak memanggil Auth berkali-kali
        $userId = Auth::id();
        // Ambil total pemasukan dan pengeluaran dana darurat, dikelompokkan berdasarkan tipe
        $emergency = Emergency::selectRaw("type, SUM(amount) as total")
            ->where('user_id', $userId)->groupBy('type')->pluck('total', 'type');
        // Ambil total pemasukan dan pengeluaran harian, dikelompokkan berdasarkan tipe
        $daily = Daily::selectRaw("type, SUM(amount) as total")
            ->where('user_id', $userId)->groupBy('type')->pluck('total', 'type');
        // Hitung total pengeluaran dalam 7 hari terakhir
        $dailyLast7 = Daily::where('user_id', $userId)
            ->where('type', 'pengeluaran')
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->sum('amount');
        // Ambil total amount dan quantity dari investasi (DCA), dikelompokkan berdasarkan tipe (beli/jual)
        $dca = Dca::selectRaw("type, SUM(amount) as amount_total, SUM(quantity) as quantity_total")
            ->where('user_id', $userId)->groupBy('type')->get()->keyBy('type');
        // Hitung dana darurat saat ini = pemasukan - pengeluaran
        $this->danaDaruratSum = ($emergency['pemasukan'] ?? 0) - ($emergency['pengeluaran'] ?? 0);
        // Tentukan warna berdasarkan nilai dana darurat
        $this->danaDaruratColor = match (true) {
            $this->danaDaruratSum > 2_000_000 => 'text-success',  // hijau
            $this->danaDaruratSum > 1_000_000 => 'text-warning',  // kuning
            default => 'text-error',                              // merah
        };
        // Hitung ideal dana darurat (6x pengeluaran)
        $this->idealEmergency = ($emergency['pengeluaran'] ?? 0) * 6;
        // Hitung sisa dana harian = pemasukan - pengeluaran
        $this->danaHarianSum = ($daily['pemasukan'] ?? 0) - ($daily['pengeluaran'] ?? 0);
        // Tentukan warna berdasarkan nilai dana harian
        $this->danaHarianColor = match (true) {
            $this->danaHarianSum > 3_50_000 => 'text-success',  // hijau
            $this->danaHarianSum > 1_50_000 => 'text-warning',  // kuning
            default => 'text-error',                              // merah
        };
        // Hitung rata-rata pengeluaran harian selama 7 hari terakhir
        $this->dailyAverage = floor($dailyLast7 / 7);
        // Hitung total modal investasi = total beli - total jual
        $this->investasiSum = ($dca['beli']->amount_total ?? 0) - ($dca['jual']->amount_total ?? 0);
        // Tentukan warna berdasarkan nilai dana investasi
        $this->investasiColor = match (true) {
            $this->investasiSum > 0 => 'text-success',
            default => 'text-slate-400',
        };
        // Hitung total Bitcoin yang dimiliki = quantity beli - quantity jual
        $this->bitcoinSum = ($dca['beli']->quantity_total ?? 0) - ($dca['jual']->quantity_total ?? 0);
        // Hitung nilai portofolio saat ini = jumlah bitcoin × harga BTC sekarang
        $this->portofolioSum = $this->bitcoinSum * ($this->bitcoinIdr ?? 0);
        // Tentukan warna berdasarkan nilai portofolio
        $this->portofolioColor = match (true) {
            $this->portofolioSum > $this->investasiSum => 'text-success',
            default => 'text-error',
        };
        // Tentukan tooltip berdasarkan nilai portofolio
        $this->portofolioTooltip = match (true) {
            $this->portofolioSum > $this->investasiSum => 'Good Job...',
            default => 'Bad Job...',
        };
        // Hitung selisih keuntungan/rugi = nilai portofolio - modal investasi
        $this->selisihSum = $this->portofolioSum - $this->investasiSum;
        // Tentukan warna berdasarkan nilai selisih
        $this->selisihColor = match (true) {
            $this->selisihSum > 0 => 'text-success',
            default => 'text-error',
        };
        // Hitung persentase keuntungan/rugi
        $this->persentaseSum = $this->investasiSum == 0 ? 0 : ($this->selisihSum / $this->investasiSum) * 100;

        // Data untuk chart
        $this->myChart = [
            'type' => 'bar',
            'data' => [
                'labels' => ['Dana Darurat', 'Dana Harian', 'Investasi', 'Portfolio', 'Selisih', 'Persentase'],
                'datasets' => [
                    [
                        'label' => '(DCA‑BTC)',
                        'data' => [
                            $this->danaDaruratSum,
                            $this->danaHarianSum,
                            $this->investasiSum,
                            $this->portofolioSum,
                            $this->selisihSum,
                            null,
                        ],
                        'backgroundColor' => [
                            // Dana Darurat
                            match (true) {
                                $this->danaDaruratSum < 0 => 'rgba(220, 38, 38, 0.7)', // merah pekat
                                $this->danaDaruratSum > 2_000_000 => 'rgba(16, 185, 129, 0.7)', // hijau
                                $this->danaDaruratSum > 1_000_000 => 'rgba(245, 158, 11, 0.7)', // kuning
                                default => 'rgba(239, 68, 68, 0.7)', // merah biasa
                            },

                            // Dana Harian
                            match (true) {
                                $this->danaHarianSum < 0 => 'rgba(220, 38, 38, 0.7)',
                                $this->danaHarianSum > 350_000 => 'rgba(16, 185, 129, 0.7)',
                                $this->danaHarianSum > 150_000 => 'rgba(245, 158, 11, 0.7)',
                                default => 'rgba(239, 68, 68, 0.7)',
                            },

                            // Investasi
                            $this->investasiSum >= 0 ? 'rgba(59,130,246,0.5)' : 'rgba(239,68,68,0.7)',

                            // Portfolio
                            $this->portofolioSum >= $this->investasiSum ? 'rgba(16, 185, 129, 0.7)' : 'rgba(239, 68, 68, 0.7)',

                            // Selisih
                            $this->selisihSum >= 0 ? 'rgba(16, 185, 129, 0.7)' : 'rgba(239, 68, 68, 0.7)',

                            // NULL (Persentase — ini di dataset ke-2, jadi NULL di sini)
                            null,
                        ],
                        // 'borderColor' => 'rgba(54,162,235,1)',
                        // 'borderWidth' => 1,
                        'yAxisID' => 'y',
                        // 'barThickness' => 80, // ✅ kontrol ukuran tetap
                        'maxBarThickness' => 80, // ✅ kontrol ukuran tetap & responsive
                        'grouped' => true,
                    ],
                    [
                        'label' => 'Persentase (%)',
                        'data' => [null, null, null, null, null, $this->persentaseSum],
                        'backgroundColor' => $this->persentaseSum >= 0
                            ? 'rgba(16, 185, 129, 0.5)'
                            : 'rgba(239, 68, 68, 0.5)',
                        // 'borderColor' => 'rgba(255,159,64,1)',
                        // 'borderWidth' => 1,
                        'yAxisID' => 'y1',
                        'maxBarThickness' => 80, // ✅ kontrol ukuran tetap & responsive
                        'grouped' => false, // ✅ agar muncul sendirian di tengah label
                        // 'base' => -100, // ✅ Tambahkan ini agar bar dimulai dari 0 (bukan dari bawah/min)
                    ],
                ],

            ],
            'options' => [
                'responsive' => true,
                'maintainAspectRatio' => false, // ✅ penting untuk fleksibel tinggi
                'plugins' => [
                    'tooltip' => ['mode' => 'index', 'intersect' => false],
                    'legend' => ['position' => 'top'],
                ],
                'scales' => [
                    'y' => [
                        'type' => 'linear',
                        'position' => 'left',
                        'title' => ['display' => true, 'text' => 'Jumlah (Rp)'],
                        'beginAtZero' => true,
                        'min' => 0,
                    ],
                    'y1' => [
                        'type' => 'linear',
                        'position' => 'right',
                        'title' => ['display' => true, 'text' => 'Persentase (%)'],
                        'beginAtZero' => true,
                        // 'min' => 0,
                        'max' => 1000, // ✅ Tambahkan ini agar tinggi mengikuti rentang
                        'grid' => ['drawOnChartArea' => false],
                        'ticks' => [
                            'stepSize' => 100,
                            'autoSkip' => false,
                            'padding' => 5, // beri sedikit jarak biar gak dempet
                            'z' => 10, // pastikan ticks tampil di atas bar jika bar terlalu besar
                        ],
                    ],
                ],
                'interaction' => [
                    'mode' => 'index',
                    'intersect' => false,
                ],
            ],
            'plugins' => [
                'datalabels' => true, // aktifkan plugin, konfigurasinya nanti di JS
            ]
        ];
    }
    public function render()
    {
        return view('livewire.dashboard', [
            'investasis' => Dca::where('user_id', Auth::user()->id)->latest()->paginate(10),
            'danaDarurats' => Emergency::where('user_id', Auth::user()->id)->latest()->paginate(10),
            'danaHarians' => Daily::where('user_id', Auth::user()->id)->latest()->paginate(10),

            'daruratSum' => $this->danaDaruratSum,
            'daruratSumColor' => $this->danaDaruratColor,
            'daruratIdeal' => $this->idealEmergency,

            'harianSum' => $this->danaHarianSum,
            'harianSumColor' => $this->danaHarianColor,
            'harianAverage' => $this->dailyAverage,

            'invesSum' => $this->investasiSum,
            'invesColor' => $this->investasiColor,
            'invesBtcSum' => $this->bitcoinSum,
            'portoSum' => $this->portofolioSum,
            'portoColor' => $this->portofolioColor,
            'portoTooltip' => $this->portofolioTooltip,
            'selSum' => $this->selisihSum,
            'selColor' => $this->selisihColor,
            'persenSum' => $this->persentaseSum,

            'btcIdr' => $this->bitcoinIdr,
        ]);
    }
}
