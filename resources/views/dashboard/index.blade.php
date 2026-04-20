@extends('layouts.app')

@section('content')
    @if(!isset($hasData) || !$hasData)
        <!-- Empty State -->
        <div class="flex items-center justify-center min-h-[70vh]">
            <div class="glass rounded-3xl shadow-2xl border border-white/30 p-12 max-w-lg w-full text-center hover-lift">
                <div
                    class="w-24 h-24 mx-auto bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-xl shadow-blue-500/20 mb-6">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-2">Belum Ada Data</h3>
                <p class="text-slate-500 mb-8">Upload file Excel terlebih dahulu untuk menampilkan dashboard monitoring.</p>
                <button @click="showImportModal = true"
                    class="group inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl transition-all shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    <span>Import Data Sekarang</span>
                </button>
            </div>
        </div>
    @else
        <div class="max-w-7xl mx-auto space-y-8 pb-8">
            <!-- Dashboard Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">
                        Dashboard Overview
                    </h1>
                    <p class="text-slate-500 mt-1">Ringkasan penugasan pencacah lapangan</p>
                </div>

                <div class="flex items-center gap-3">
                    <button @click="showImportModal = true"
                        class="group flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-xl shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition-all text-sm">
                        <svg class="w-4 h-4 group-hover:rotate-180 transition-transform duration-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        <span>Upload Excel</span>
                    </button>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Card 1: Total Target -->
                <div class="glass rounded-2xl border border-white/30 p-6 hover-lift group">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500 mb-1">Total Target</p>
                            <p class="text-3xl font-bold text-slate-800">{{ number_format($totalTarget) }}</p>
                            <p class="text-xs text-slate-400 mt-1">Dokumen</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 h-1.5 w-full bg-slate-200/50 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-blue-500 to-blue-600 rounded-full w-full"></div>
                    </div>
                </div>

                <!-- Card 2: Total Selesai -->
                <div class="glass rounded-2xl border border-white/30 p-6 hover-lift group">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500 mb-1">Total Selesai</p>
                            <p class="text-3xl font-bold text-slate-800">{{ number_format($totalSubmitted) }}</p>
                            <p class="text-xs text-slate-400 mt-1">Dokumen</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 h-1.5 w-full bg-slate-200/50 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-full"
                            style="width: {{ $totalTarget > 0 ? ($totalSubmitted / $totalTarget) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <!-- Card 3: Total Petugas -->
                <div class="glass rounded-2xl border border-white/30 p-6 hover-lift group">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500 mb-1">Total Petugas</p>
                            <p class="text-3xl font-bold text-slate-800">{{ number_format($totalPetugas) }}</p>
                            <p class="text-xs text-slate-400 mt-1">Petugas Aktif</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/20 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 h-1.5 w-full bg-slate-200/50 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-purple-500 to-purple-600 rounded-full w-full"></div>
                    </div>
                </div>

                <!-- Card 4: Persentase -->
                <div class="glass rounded-2xl border border-white/30 p-6 hover-lift group">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <p class="text-sm font-medium text-slate-500 mb-1">Progress</p>
                            <p class="text-3xl font-bold text-slate-800">{{ $persenSelesai }}%</p>
                            <p class="text-xs text-slate-400 mt-1">Tingkat Penyelesaian</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/20 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="w-full bg-slate-200/50 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-gradient-to-r from-amber-500 to-orange-600 h-2.5 rounded-full transition-all duration-1000"
                            style="width: {{ $persenSelesai }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Chart & Status Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Donut Chart -->
                <div class="glass rounded-2xl border border-white/30 p-6 lg:col-span-1">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Distribusi Status</h3>
                    <div class="h-64 relative">
                        <canvas id="statusChart"></canvas>
                    </div>
                    <div class="mt-4 flex justify-center gap-6">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                            <span class="text-xs text-slate-600">OPEN</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                            <span class="text-xs text-slate-600">SUBMITTED</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                            <span class="text-xs text-slate-600">REJECTED</span>
                        </div>
                    </div>
                </div>

                <!-- Status Cards -->
                <div class="lg:col-span-2 space-y-3">
                    <div class="glass rounded-2xl border border-white/30 p-5 hover-lift">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-500">Status OPEN</p>
                                    <p class="text-2xl font-bold text-slate-800">{{ number_format($chartData['open']) }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-semibold text-blue-600">
                                    {{ $totalTarget > 0 ? round(($chartData['open'] / $totalTarget) * 100, 1) : 0 }}%
                                </span>
                                <p class="text-xs text-slate-400">dari total target</p>
                            </div>
                        </div>
                    </div>

                    <div class="glass rounded-2xl border border-white/30 p-5 hover-lift">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-500">Status SUBMITTED (Selesai)</p>
                                    <p class="text-2xl font-bold text-slate-800">{{ number_format($chartData['submitted']) }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-semibold text-emerald-600">
                                    {{ $totalTarget > 0 ? round(($chartData['submitted'] / $totalTarget) * 100, 1) : 0 }}%
                                </span>
                                <p class="text-xs text-slate-400">dari total target</p>
                            </div>
                        </div>
                    </div>

                    <div class="glass rounded-2xl border border-white/30 p-5 hover-lift">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-rose-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-500">Status REJECTED</p>
                                    <p class="text-2xl font-bold text-slate-800">{{ number_format($chartData['rejected']) }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-semibold text-rose-600">
                                    {{ $totalTarget > 0 ? round(($chartData['rejected'] / $totalTarget) * 100, 1) : 0 }}%
                                </span>
                                <p class="text-xs text-slate-400">dari total target</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rekap Per Kecamatan -->
            <div class="glass rounded-2xl border border-white/30 overflow-hidden"
                x-data="{ desaData: {{ json_encode($desaPerKecamatan) }} }">
                <div class="px-6 py-5 border-b border-slate-200/50 flex flex-wrap justify-between items-center gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800">Rekap Per Kecamatan</h3>
                            <p class="text-xs text-slate-500">{{ count($rekapKecamatan) }} Kecamatan</p>
                        </div>
                    </div>
                    <a href="{{ route('export.wilayah') }}"
                        class="group flex items-center gap-2 px-4 py-2.5 glass-light rounded-xl border border-white/30 text-emerald-700 text-sm font-medium hover:bg-emerald-50/50 transition-all">
                        <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        <span>Export Excel</span>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="bg-slate-100/50 text-slate-500 font-semibold text-xs uppercase tracking-wider">
                                <th class="px-6 py-4">Kecamatan</th>
                                <th class="px-6 py-4 text-center">Petugas</th>
                                <th class="px-6 py-4 text-center">Desa</th>
                                <th class="px-6 py-4 text-right">Target</th>
                                <th class="px-6 py-4 text-right">OPEN</th>
                                <th class="px-6 py-4 text-right">SUBMIT</th>
                                <th class="px-6 py-4 text-right">REJECT</th>
                                <th class="px-6 py-4 text-right">% Selesai</th>
                                <th class="px-6 py-4 w-12"></th>
                            </tr>
                        </thead>
                        @foreach ($rekapKecamatan as $kec)
                            @php
                                $pctKecSelesai = $kec->total_target > 0 ? round(($kec->total_submitted / $kec->total_target) * 100, 1) : 0;
                            @endphp
                            <tbody x-data="{ expanded: false }" class="border-t border-slate-200/50">
                                <tr class="hover:bg-slate-50/50 transition-colors cursor-pointer" @click="expanded = !expanded">
                                    <td class="px-6 py-4 font-medium text-slate-800">{{ $kec->kecamatan }}</td>
                                    <td class="px-6 py-4 text-center text-slate-600">{{ $kec->total_petugas }}</td>
                                    <td class="px-6 py-4 text-center text-slate-600">{{ $kec->total_desa }}</td>
                                    <td class="px-6 py-4 text-right font-medium text-slate-800">
                                        {{ number_format($kec->total_target) }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-blue-600">{{ number_format($kec->total_open) }}</td>
                                    <td class="px-6 py-4 text-right text-emerald-600 font-medium">
                                        {{ number_format($kec->total_submitted) }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-rose-600">{{ number_format($kec->total_rejected) }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex-1 bg-slate-200 rounded-full h-1.5">
                                                <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 h-1.5 rounded-full"
                                                    style="width: {{ $pctKecSelesai }}%"></div>
                                            </div>
                                            <span
                                                class="text-xs font-medium text-slate-600 w-12 text-right">{{ $pctKecSelesai }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <svg class="w-5 h-5 text-slate-400 transform transition-transform duration-300"
                                            :class="{ 'rotate-180': expanded }" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </td>
                                </tr>

                                <tr x-show="expanded" x-collapse x-cloak>
                                    <td colspan="9" class="p-0 bg-slate-50/30">
                                        <div class="px-6 py-4 pl-12">
                                            <table class="w-full text-xs bg-white/50 rounded-xl overflow-hidden">
                                                <thead class="bg-slate-100/70 text-slate-500 font-semibold">
                                                    <tr>
                                                        <th class="px-4 py-2.5 text-left">Desa</th>
                                                        <th class="px-4 py-2.5 text-right">Target</th>
                                                        <th class="px-4 py-2.5 text-right text-blue-600">OPEN</th>
                                                        <th class="px-4 py-2.5 text-right text-emerald-600">SUBMIT</th>
                                                        <th class="px-4 py-2.5 text-right text-rose-600">REJECT</th>
                                                        <th class="px-4 py-2.5 text-right">% Selesai</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <template x-if="desaData['{{ $kec->level_3_code }}']">
                                                        <template x-for="desa in desaData['{{ $kec->level_3_code }}']"
                                                            :key="desa.desa">
                                                            <tr class="border-t border-slate-100">
                                                                <td class="px-4 py-2.5" x-text="desa.desa"></td>
                                                                <td class="px-4 py-2.5 text-right font-medium text-slate-700"
                                                                    x-text="desa.total_target"></td>
                                                                <td class="px-4 py-2.5 text-right" x-text="desa.total_open"></td>
                                                                <td class="px-4 py-2.5 text-right font-medium"
                                                                    x-text="desa.total_submitted"></td>
                                                                <td class="px-4 py-2.5 text-right" x-text="desa.total_rejected">
                                                                </td>
                                                                <td class="px-4 py-2.5">
                                                                    <div class="flex items-center gap-2 justify-end">
                                                                        <div class="w-16 bg-slate-200 rounded-full h-1.5">
                                                                            <div class="bg-emerald-500 h-1.5 rounded-full"
                                                                                :style="`width: ${desa.total_target > 0 ? ((desa.total_submitted / desa.total_target) * 100).toFixed(1) : 0}%`">
                                                                            </div>
                                                                        </div>
                                                                        <span class="text-slate-600 w-10 text-right"
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

            <!-- Rekap Per Petugas -->
            <div class="glass rounded-2xl border border-white/30 overflow-hidden" x-data="{ 
                                                                                        search: '', 
                                                                                        petugas: {{ json_encode($rekapPetugas) }},
                                                                                        get filteredPetugas() {
                                                                                            return this.petugas.filter(p => {
                                                                                                return p.nama.toLowerCase().includes(this.search.toLowerCase()) || 
                                                                                                       p.email.toLowerCase().includes(this.search.toLowerCase());
                                                                                            });
                                                                                        }
                                                                                    }">
                <div class="px-6 py-5 border-b border-slate-200/50 flex flex-wrap justify-between items-center gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800">Rekap Per Petugas</h3>
                            <p class="text-xs text-slate-500">{{ count($rekapPetugas) }} Petugas</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" x-model="search" placeholder="Cari nama atau email..."
                                class="w-64 pl-10 pr-4 py-2.5 glass-light rounded-xl border border-white/30 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                        </div>
                        <a href="{{ route('export.petugas') }}"
                            class="group flex items-center gap-2 px-4 py-2.5 glass-light rounded-xl border border-white/30 text-emerald-700 text-sm font-medium hover:bg-emerald-50/50 transition-all">
                            <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            <span>Export Excel</span>
                        </a>
                    </div>
                </div>

                <div class="max-h-[500px] overflow-y-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="sticky top-0 z-10 bg-slate-100/80 backdrop-blur-sm">
                            <tr class="text-slate-500 font-semibold text-xs uppercase tracking-wider">
                                <th class="px-6 py-4">Nama Petugas</th>
                                <th class="px-6 py-4 text-center">Desa</th>
                                <th class="px-6 py-4 text-right">Target</th>
                                <th class="px-6 py-4 text-right">OPEN</th>
                                <th class="px-6 py-4 text-right">SUBMIT</th>
                                <th class="px-6 py-4 text-right">REJECT</th>
                                <th class="px-6 py-4 text-right">% Selesai</th>
                                <th class="px-6 py-4 text-center">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="p in filteredPetugas" :key="p.petugas_id">
                                <tr class="border-t border-slate-200/50 hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-slate-800" x-text="p.nama"></p>
                                        <p class="text-xs text-slate-500 mt-0.5" x-text="p.email"></p>
                                    </td>
                                    <td class="px-6 py-4 text-center text-slate-600" x-text="p.total_desa"></td>
                                    <td class="px-6 py-4 text-right font-medium text-slate-800"
                                        x-text="p.total_target.toLocaleString()"></td>
                                    <td class="px-6 py-4 text-right text-slate-600" x-text="p.total_open.toLocaleString()"></td>
                                    <td class="px-6 py-4 text-right font-medium text-emerald-600"
                                        x-text="p.total_submitted.toLocaleString()"></td>
                                    <td class="px-6 py-4 text-right text-rose-500" x-text="p.total_rejected.toLocaleString()">
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 justify-end">
                                            <div class="w-16 bg-slate-200 rounded-full h-1.5">
                                                <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 h-1.5 rounded-full"
                                                    :style="`width: ${p.total_target > 0 ? ((p.total_submitted/p.total_target)*100).toFixed(1) : 0}%`">
                                                </div>
                                            </div>
                                            <span class="text-xs font-medium text-slate-600 w-10 text-right"
                                                x-text="`${p.total_target > 0 ? ((p.total_submitted/p.total_target)*100).toFixed(1) : 0}%`"></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a :href="`/petugas/${p.petugas_id}`"
                                            class="inline-flex items-center justify-center w-8 h-8 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all shadow-sm hover:shadow-md">
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
                                <td colspan="8" class="text-center py-12 text-slate-500">
                                    <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                    <p class="font-medium">Tidak ada petugas ditemukan</p>
                                    <p class="text-sm mt-1">Coba ubah kata kunci pencarian</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

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
                            borderRadius: 8,
                            spacing: 4,
                            hoverOffset: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#1e293b',
                                titleColor: '#f1f5f9',
                                bodyColor: '#cbd5e1',
                                padding: 12,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function (context) {
                                        let label = context.label || '';
                                        if (label) label += ': ';
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