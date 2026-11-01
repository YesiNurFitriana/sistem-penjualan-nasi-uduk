@extends('layout')

@section('title', 'Dashboard')

@section('content')

{{-- Kartu ringkasan informasi dashboard --}}
<div class="row g-3 mb-3">

    {{-- Menampilkan data ringkasan dalam bentuk kartu --}}
    @foreach([
        ['Penjualan hari ini', 'Rp '.number_format($omzet, 0, ',', '.'), 'bi-cash-stack', 'success'],
        ['Pesanan online menunggu', $pending, 'bi-bag-check', 'warning'],
        ['Pesanan acara menunggu', $pendingAcara, 'bi-calendar-event', 'info'],
        ['Menu stok menipis (≤5)', $menipis, 'bi-exclamation-triangle', 'danger']
    ] as [$l, $v, $ic, $c])

        <div class="col-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-3">

                    {{-- Ikon berdasarkan jenis informasi --}}
                    <div class="rounded-3 bg-{{ $c }}-subtle text-{{ $c }} p-3 fs-4">
                        <i class="bi {{ $ic }}"></i>
                    </div>

                    {{-- Judul dan nilai informasi --}}
                    <div>
                        <div class="text-muted small">{{ $l }}</div>
                        <div class="h5 fw-bold mb-0">{{ $v }}</div>
                    </div>

                </div>
            </div>
        </div>

    @endforeach

</div>

{{-- Grafik statistik dashboard --}}
<div class="row g-3">

    {{-- Grafik penjualan selama 7 hari terakhir --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h2 class="h6 fw-bold">Penjualan 7 Hari Terakhir (Rp)</h2>
                <canvas id="c1" height="120"></canvas>
            </div>
        </div>
    </div>

    {{-- Grafik jumlah porsi terjual per menu --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h2 class="h6 fw-bold">Porsi Terjual per Menu (7 hari)</h2>
                <canvas id="c2"></canvas>
            </div>
        </div>
    </div>

    {{-- Grafik stok kasir hari ini --}}
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h2 class="h6 fw-bold">Stok Kasir Hari Ini (porsi)</h2>
                <canvas id="c3" height="70"></canvas>
            </div>
        </div>
    </div>

</div>

{{-- Memasukkan library Chart.js dan script grafik --}}
@push('js')

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>

<script>

    // Warna yang digunakan pada grafik
    const G = [
        '#14532d',
        '#16a34a',
        '#4ade80',
        '#86efac',
        '#facc15',
        '#a3a3a3'
    ];

    // Mengambil label tanggal dari controller
    const L = @json($labels);

    // Grafik penjualan kasir dan online selama 7 hari
    new Chart(c1, {
        type: 'bar',
        data: {
            labels: L,
            datasets: [
                {
                    label: 'Kasir',
                    data: @json($kasir),
                    backgroundColor: '#16a34a'
                },
                {
                    label: 'Online',
                    data: @json($online),
                    backgroundColor: '#86efac'
                }
            ]
        },
        options: {
            scales: {
                x: { stacked: true },
                y: { stacked: true, beginAtZero: true }
            }
        }
    });

    // Grafik donat jumlah porsi terjual per menu
    new Chart(c2, {
        type: 'doughnut',
        data: {
            labels: @json($names),
            datasets: [
                {
                    data: @json($terjual),
                    backgroundColor: G
                }
            ]
        },
        options: {
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // Grafik stok kasir hari ini berdasarkan menu
    new Chart(c3, {
        type: 'bar',
        data: {
            labels: @json($names),
            datasets: [
                {
                    label: 'Stok kasir',
                    data: @json($stok),
                    backgroundColor: '#16a34a'
                }
            ]
        },
        options: {
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

</script>

@endpush

@endsection