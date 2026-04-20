@extends('layouts.app')

@section('content')
    @if(!isset($hasData) || !$hasData)
        <div class="flex items-center justify-center h-full">
            <div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100 p-12 max-w-lg w-full">
                <svg class="mx-auto h-20 w-20 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                <h3 class="mt-6 text-xl font-bold text-gray-800">Belum ada data</h3>
                <p class="mt-2 text-gray-500">Upload file Excel terlebih dahulu untuk menampilkan dashboard.</p>
                <a href="{{ route('import.index') }}"
                    class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors shadow-sm">
                    Import Data Sekarang
                </a>
            </div>
        </div>
    @else
        <div class="space-y-6 pb-12">
            <!-- Dashboard Header -->
            <div class="flex justify-between items-end">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                    <p class="text-sm text-gray-500 mt-1">Ringkasan penugasan pencacah lapangan</p>
                </div>

                <div class="flex items-center gap-2 bg-white px-4 py-2 border border-gray-200 rounded-lg text-sm shadow-sm">
                    <span
                        class="w-2.5 h-2.5 rounded-full {{ $persenSelesai == 100 ? 'bg-green-500' : 'bg-blue-500 animate-pulse' }}"></span>
                    <span class="text-gray-600">Dataset:</span>
                    <span class="font-semibold text-gray-800">{{ $latestImport->original_name }}</span>
                </div>
            </div>

            <!-- Section 1: Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 border-l-4 border-l-blue-500">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Target Dokumen</p>
                            <p class="text-3xl font-bold text-gray-800">{{ number_format($totalTarget) }}</p>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg text-blue-600 h-12 w-12 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 border-l-4 border-l-green-500">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Selesai</p>
                            <p class="text-3xl font-bold text-gray-800">{{ number_format($totalSubmitted) }}</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-lg text-green-600 h-12 w-12 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 border-l-4 border-l-purple-500">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Petugas</p>
                            <p class="text-3xl font-bold text-gray-800">{{ number_format($totalPetugas) }}</p>
                        </div>
                        <div class="p-3 bg-purple-50 rounded-lg text-purple-600 h-12 w-12 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 border-l-4 border-l-emerald-400">
                    <div class="flex justify-between">
                        <div class="w-full">
                            <p class="text-sm font-medium text-gray-500 mb-1">Persentase Selesai</p>
                            <div class="flex items-center justify-between mb-2 mt-2">
                                <span class="text-3xl font-bold text-gray-800">{{ $persenSelesai }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $persenSelesai }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Chart & Status Info -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 col-span-2 lg:col-span-1">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Status</h3>
                    <div class="h-64 relative flex items-center justify-center">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-0 col-span-2 lg:col-span-2 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="text-lg font-semibold text-gray-800">Detail Status Penugasan</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-4 border border-gray-100 rounded-lg bg-blue-50/30">
                                <div class="flex items-center gap-3">
                                    <span class="w-3 h-3 rounded-full bg-blue-500 shadow-sm"></span>
                                    <span class="font-medium text-gray-700">OPEN</span>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-gray-800">{{ number_format($chartData['open']) }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $totalTarget > 0 ? round(($chartData['open'] / $totalTarget) * 100, 1) : 0 }}%
                                    </p>
                                </div>
                            </div>

                            <div class="flex justify-between items-center p-4 border border-gray-100 rounded-lg bg-green-50/30">
                                <div class="flex items-center gap-3">
                                    <span class="w-3 h-3 rounded-full bg-green-500 shadow-sm"></span>
                                    <span class="font-medium text-gray-700">SUBMITTED (Selesai)</span>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-gray-800">{{ number_format($chartData['submitted']) }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $totalTarget > 0 ? round(($chartData['submitted'] / $totalTarget) * 100, 1) : 0 }}%
                                    </p>
                                </div>
                            </div>

                            <div class="flex justify-between items-center p-4 border border-gray-100 rounded-lg bg-red-50/30">
                                <div class="flex items-center gap-3">
                                    <span class="w-3 h-3 rounded-full bg-red-500 shadow-sm"></span>
                                    <span class="font-medium text-gray-700">REJECTED</span>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-gray-800">{{ number_format($chartData['rejected']) }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $totalTarget > 0 ? round(($chartData['rejected'] / $totalTarget) * 100, 1) : 0 }}%
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: Rekap Per Kecamatan (Collapsible) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden"
                x-data="{ desaData: {{ json_encode($desaPerKecamatan) }} }">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-semibold text-gray-800">Rekap Per Kecamatan</h3>
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-semibold rounded-full border border-gray-200">
                        {{ count($rekapKecamatan) }} Kecamatan
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr
                                class="bg-gray-100/50 text-gray-500 font-semibold border-b border-gray-200 uppercase text-xs tracking-wider">
                                <th class="px-6 py-4">Kecamatan</th>
                                <th class="px-6 py-4 text-center">Petugas</th>
                                <th class="px-6 py-4 text-center">Desa</th>
                                <th class="px-6 py-4 text-right">Target</th>
                                <th class="px-6 py-4 text-right">OPEN</th>
                                <th class="px-6 py-4 text-right">SUBMIT</th>
                                <th class="px-6 py-4 text-right">REJECT</th>
                                <th class="px-6 py-4 text-right w-32">% Selesai</th>
                                <th class="px-6 py-4 w-12"></th>
                            </tr>
                        </thead>
                        @foreach ($rekapKecamatan as $kec)
                            @php
                                $pctKecSelesai = $kec->total_target > 0 ? round(($kec->total_submitted / $kec->total_target) * 100, 1) : 0;
                            @endphp
                            <!-- tbody for each row's collapse state -->
                            <tbody x-data="{ expanded: false }" class="divide-y divide-gray-100 group">
                                <tr class="hover:bg-blue-50/30 transition-colors cursor-pointer group"
                                    @click="expanded = !expanded">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $kec->kecamatan }}</td>
                                    <td class="px-6 py-4 text-center text-gray-600">{{ $kec->total_petugas }}</td>
                                    <td class="px-6 py-4 text-center text-gray-600">{{ $kec->total_desa }}</td>
                                    <td class="px-6 py-4 text-right font-medium text-gray-800">
                                        {{ number_format($kec->total_target) }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-blue-600">{{ number_format($kec->total_open) }}</td>
                                    <td class="px-6 py-4 text-right text-green-600 font-medium">
                                        {{ number_format($kec->total_submitted) }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-red-600">{{ number_format($kec->total_rejected) }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 bg-gray-200 rounded-full h-1.5">
                                                <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ $pctKecSelesai }}%">
                                                </div>
                                            </div>
                                            <span class="text-xs text-gray-500 w-8 text-right">{{ $pctKecSelesai }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <svg class="w-5 h-5 text-gray-400 transform transition-transform group-hover:text-blue-500"
                                            :class="{ 'rotate-180': expanded }" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </td>
                                </tr>

                                <!-- Sub tabel (Desa) -->
                                <tr x-show="expanded" x-collapse x-cloak>
                                    <td colspan="9" class="p-0 bg-gray-50 border-t border-gray-100 inset-shadow-sm">
                                        <div class="px-6 py-4 pl-12 pr-6">
                                            <table
                                                class="w-full text-xs text-left bg-white border border-gray-200 rounded shadow-sm overflow-hidden pb-2 mb-2">
                                                <thead class="bg-gray-100/80 text-gray-500 font-semibold border-b border-gray-200">
                                                    <tr>
                                                        <th class="px-4 py-2 border-r border-gray-200">Desa</th>
                                                        <th class="px-4 py-2 text-right border-r border-gray-200">Target</th>
                                                        <th class="px-4 py-2 text-right border-r border-gray-200 text-blue-600">OPEN
                                                        </th>
                                                        <th class="px-4 py-2 text-right border-r border-gray-200 text-green-600">
                                                            SUBMIT</th>
                                                        <th class="px-4 py-2 text-right border-r border-gray-200 text-red-600">
                                                            REJECT</th>
                                                        <th class="px-4 py-2 text-right w-32">% Selesai</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-100">
                                                    <template x-if="desaData['{{ $kec->level_3_code }}']">
                                                        <template x-for="desa in desaData['{{ $kec->level_3_code }}']"
                                                            :key="desa.desa">
                                                            <tr class="hover:bg-gray-50">
                                                                <td class="px-4 py-2 border-r border-gray-100" x-text="desa.desa">
                                                                </td>
                                                                <td class="px-4 py-2 text-right border-r border-gray-100 font-medium text-gray-700"
                                                                    x-text="desa.total_target"></td>
                                                                <td class="px-4 py-2 text-right border-r border-gray-100"
                                                                    x-text="desa.total_open"></td>
                                                                <td class="px-4 py-2 text-right border-r border-gray-100 font-medium"
                                                                    x-text="desa.total_submitted"></td>
                                                                <td class="px-4 py-2 text-right border-r border-gray-100"
                                                                    x-text="desa.total_rejected"></td>
                                                                <td class="px-4 py-2">
                                                                    <div class="flex items-center gap-2">
                                                                        <div
                                                                            class="flex-1 bg-gray-200 rounded-full h-1.5 line-clamp-1">
                                                                            <div class="bg-green-500 h-1.5 rounded-full"
                                                                                :style="`width: ${desa.total_target > 0 ? ((desa.total_submitted / desa.total_target) * 100).toFixed(1) : 0}%`">
                                                                            </div>
                                                                        </div>
                                                                        <span class="text-xs text-gray-500 w-8 text-right"
                                                                            x-text="`${desa.total_target > 0 ? ((desa.total_submitted / desa.total_target) * 100).toFixed(1) : 0}%`"></span>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </template>
                                                    </template>
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>

            <!-- Section 4: Rekap Per Petugas dengan Search -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" x-data="{ 
                                        search: '', 
                                        petugas: {{ json_encode($rekapPetugas) }},
                                        get filteredPetugas() {
                                            return this.petugas.filter(p => {
                                                return p.nama.toLowerCase().includes(this.search.toLowerCase()) || 
                                                       p.email.toLowerCase().includes(this.search.toLowerCase());
                                            });
                                        }
                                    }">

                <div
                    class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-gray-50/50">
                    <h3 class="text-lg font-semibold text-gray-800">Rekap Per Petugas</h3>

                    <div class="relative w-full md:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" x-model="search" placeholder="Cari nama atau email..."
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition">
                    </div>
                </div>

                <div class="max-h-96 overflow-y-auto">
                    <table class="w-full text-left border-collapse text-sm relative">
                        <thead class="sticky top-0 z-10 bg-gray-100 shadow-sm outline-1 outline-gray-200">
                            <tr class="text-gray-500 font-semibold uppercase text-xs tracking-wider">
                                <th class="px-6 py-4">Nama Petugas</th>
                                <th class="px-6 py-4 text-center">Desa</th>
                                <th class="px-6 py-4 text-right">Target</th>
                                <th class="px-6 py-4 text-right">OPEN</th>
                                <th class="px-6 py-4 text-right">SUBMIT</th>
                                <th class="px-6 py-4 text-right">REJECT</th>
                                <th class="px-6 py-4 text-right">% Selesai</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <template x-for="p in filteredPetugas" :key="p.petugas_id">
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-gray-900" x-text="p.nama"></p>
                                        <p class="text-xs text-gray-500 mt-0.5" x-text="p.email"></p>
                                    </td>
                                    <td class="px-6 py-4 text-center text-gray-600" x-text="p.total_desa"></td>
                                    <td class="px-6 py-4 text-right font-medium text-gray-800"
                                        x-text="p.total_target.toLocaleString()"></td>
                                    <td class="px-6 py-4 text-right text-gray-600" x-text="p.total_open.toLocaleString()"></td>
                                    <td class="px-6 py-4 text-right font-medium text-green-600"
                                        x-text="p.total_submitted.toLocaleString()"></td>
                                    <td class="px-6 py-4 text-right text-red-500" x-text="p.total_rejected.toLocaleString()">
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 justify-end">
                                            <div class="w-16 bg-gray-200 rounded-full h-1.5 flex-1 max-w-[80px]">
                                                <div class="bg-green-500 h-1.5 rounded-full"
                                                    :style="`width: ${p.total_target > 0 ? ((p.total_submitted/p.total_target)*100).toFixed(1) : 0}%`">
                                                </div>
                                            </div>
                                            <span class="text-xs text-gray-600 w-8 text-right"
                                                x-text="`${p.total_target > 0 ? ((p.total_submitted/p.total_target)*100).toFixed(1) : 0}%`"></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <!-- Use route helper from string replacement via x-bind -->
                                        <a :href="`/petugas/${p.petugas_id}`"
                                            class="inline-flex items-center justify-center p-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 hover:text-blue-700 transition tooltip relative group">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            </template>
                            <tr x-show="filteredPetugas.length === 0">
                                <td colspan="8" class="text-center py-8 text-gray-500 bg-gray-50">Tidak ada petugas ditemukan
                                    untuk pencarian tersebut.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Chart Configuration Script -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const ctx = document.getElementById('statusChart').getContext('2d');
                const data = @json($chartData);

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['OPEN', 'SUBMITTED', 'REJECTED'],
                        datasets: [{
                            data: [data.open, data.submitted, data.rejected],
                            backgroundColor: ['#3B82F6', '#10B981', '#EF4444'],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        let label = context.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed !== null) {
                                            label += new Intl.NumberFormat('id-ID').format(context.parsed) + ' Dokumen';
                                        }
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endif
@endsection