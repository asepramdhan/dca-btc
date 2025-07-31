<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon; // Tetap menggunakan Carbon jika ada kebutuhan lain di masa depan

class SimulationChart extends Component
{
    public int $nominal = 100000; // Nominal investasi per bulan
    public int $durasi = 24; // Durasi simulasi dalam bulan
    public int $rataRataHargaBeliInput = 1000000000; // Rata-rata harga beli yang diinput pengguna
    public int $hargaBtc = 1300000000; // Harga BTC saat ini (diinput pengguna untuk valuasi akhir)

    public array $simulasiChart = []; // Data untuk chart

    // Properti historicalPrices dan metode terkait dihapus/tidak digunakan lagi
    // karena perhitungan BTC yang dimiliki sekarang berdasarkan rataRataHargaBeliInput.

    public function mount(): void
    {
        // Panggil updateChart saat komponen dimuat untuk menampilkan data awal
        $this->updateChart();
    }

    public function updateChart(): void
    {
        $labels = [];
        $investasiData = []; // Data untuk bar total investasi
        $nilaiSekarangData = []; // Data untuk bar nilai Bitcoin saat ini

        // Inisialisasi total investasi kumulatif
        $totalInvestedAmountCumulative = 0;

        // Definisi bulan target untuk label dan data bar
        $targetMonths = [
            1 => '1 Bulan',
            3 => '3 Bulan',
            6 => '6 Bulan',
            12 => '1 Tahun',
            24 => '2 Tahun',
            36 => '3 Tahun',
            60 => '5 Tahun',
        ];

        // Pastikan rataRataHargaBeliInput tidak nol untuk menghindari pembagian dengan nol
        if ($this->rataRataHargaBeliInput <= 0) {
            // Atur nilai default atau tampilkan pesan error
            // Untuk simulasi ini, kita bisa set ke nilai yang sangat kecil untuk menghindari error,
            // atau hentikan fungsi dan kosongkan chart.
            // Saya akan mengosongkan chart untuk menunjukkan input tidak valid.
            $this->simulasiChart = [];
            return;
        }

        // Iterasi dari bulan pertama hingga durasi yang dipilih
        for ($i = 0; $i < $this->durasi; $i++) {
            $currentMonth = $i + 1;

            // Akumulasikan total investasi
            $totalInvestedAmountCumulative += $this->nominal;

            // Hitung hipotesis jumlah BTC yang dimiliki
            // Jika rata-rata harga beli adalah X, maka dengan total investasi Y,
            // Anda akan memiliki (Y / X) BTC.
            $hypotheticalBtcAccumulated = $totalInvestedAmountCumulative / $this->rataRataHargaBeliInput;

            // Hitung nilai saat ini berdasarkan harga BTC yang diinput pengguna
            $currentValue = $hypotheticalBtcAccumulated * $this->hargaBtc;

            // Hanya tambahkan data ke array chart jika bulan saat ini adalah salah satu bulan target
            if (array_key_exists($currentMonth, $targetMonths)) {
                $labels[] = $targetMonths[$currentMonth];
                $investasiData[] = $totalInvestedAmountCumulative;
                $nilaiSekarangData[] = $currentValue;
            }
        }

        // Perbarui data chart
        $this->simulasiChart = [
            'type' => 'bar',
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Total Investasi (Rp)',
                        'data' => $investasiData,
                        'backgroundColor' => 'rgba(59,130,246,0.7)', // Biru Tailwind 500
                        'maxBarThickness' => 60,
                        'yAxisID' => 'y',
                    ],
                    [
                        'label' => 'Nilai Bitcoin Saat Ini (Rp)', // Label lebih jelas
                        'data' => $nilaiSekarangData,
                        'backgroundColor' => 'rgba(16,185,129,0.7)', // Hijau Tailwind 500
                        'maxBarThickness' => 60,
                        'yAxisID' => 'y',
                    ],
                ],
            ],
            'options' => [
                'responsive' => true,
                'maintainAspectRatio' => false,
                'plugins' => [
                    'tooltip' => ['mode' => 'index', 'intersect' => false],
                    'legend' => ['position' => 'top'],
                ],
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                        'title' => ['display' => true, 'text' => 'Jumlah (Rp)'],
                    ],
                    'x' => [
                        'ticks' => [
                            'autoSkip' => false,
                            'maxRotation' => 45,
                            'minRotation' => 0,
                        ]
                    ]
                ],
            ],
        ];
    }

    public function render()
    {
        return view('livewire.simulation-chart');
    }
}
