@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 pb-12">
    <!-- Officer Header -->
    <div class="glass rounded-2xl border border-white/30 p-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-blue-400/10 to-purple-400/10 rounded-full blur-3xl -mr-20 -mt-20"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-gradient-to-tr from-emerald-400/10 to-cyan-400/10 rounded-full blur-3xl -ml-20 -mb-20"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center gap-6">
            <div class="flex items-center gap-5 flex-1">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-xl shadow-blue-500/20">
                    <span class="text-3xl font-bold text-white">{{ strtoupper(substr($petugas->nama, 0, 1)) }}</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">
                        {{ $petugas->nama }}
                    </h1>
                    <div class="flex items-center gap-2 mt-1">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-slate-500">{{ $petugas->email }}</span>
                    </div>
                </div>
            </div>
            
            <div class="w-full md:w-80 glass-light rounded-xl p-5 border border-white/30">
                <div class="flex justify-between items-end mb-3">
                    <span class="text-sm font-medium text-slate-500">Progress Penugasan</span>
                    <span class="text-3xl font-bold text-slate-800">{{ $persenSelesai }}%</span>
                </div>
                <div class="w-full bg-slate-200/50 rounded-full h-2.5 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 h-2.5 rounded-full transition-all duration-1000" 
                         style="width: {{ $persenSelesai }}%"></div>
                </div>
                <p class="text-xs text-slate-400 mt-3 flex items-center justify-between">
                    <span>{{ number_format($stats->total_submitted) }} dari {{ number_format($stats->total_target) }} Dokumen</span>
                    <span class="font-medium text-emerald-600">{{ $stats->total_target > 0 ? round(($stats->total_submitted / $stats->total_target) * 100, 1) : 0 }}%</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="glass rounded-xl border border-white/30 p-5 hover-lift">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Target</p>
                    <p class="text-2xl font-bold text-slate-800">{{ number_format($stats->total_target) }}</p>
                </div>
            </div>
        </div>

        <div class="glass rounded-xl border border-white/30 p-5 hover-lift border-l-4 border-l-blue-500">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-blue-500 uppercase tracking-wider">Total OPEN</p>
                    <p class="text-2xl font-bold text-slate-800">{{ number_format($stats->total_open) }}</p>
                </div>
            </div>
        </div>

        <div class="glass rounded-xl border border-white/30 p-5 hover-lift border-l-4 border-l-emerald-500">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-emerald-500 uppercase tracking-wider">Total SUBMITTED</p>
                    <p class="text-2xl font-bold text-slate-800">{{ number_format($stats->total_submitted) }}</p>
                </div>
            </div>
        </div>

        <div class="glass rounded-xl border border-white/30 p-5 hover-lift border-l-4 border-l-rose-500">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-rose-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-rose-500 uppercase tracking-wider">Total REJECTED</p>
                    <p class="text-2xl font-bold text-slate-800">{{ number_format($stats->total_rejected) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Wilayah & Chart -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        <!-- Table -->
        <div class="lg:col-span-2 glass rounded-2xl border border-white/30 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200/50 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-800">Detail Wilayah Penugasan</h3>
                        <p class="text-xs text-slate-500">{{ count($detailPerDesa) }} Kecamatan, {{ $stats->total_desa }} Desa</p>
                    </div>
                </div>
                <span class="px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">
                    {{ $stats->total_desa }} Desa
                </span>
            </div>
            
            <div class="overflow-x-auto max-h-[500px] overflow-y-auto">
                <table class="w-full text-left text-sm">
                    <thead class="sticky top-0 z-10 bg-slate-100/80 backdrop-blur-sm">
                        <tr class="text-slate-500 font-semibold text-xs uppercase tracking-wider text-center">
                            <th class="px-5 py-3 text-left">Wilayah</th>
                            <th class="px-5 py-3">Target</th>
                            <th class="px-5 py-3 text-blue-600">OPEN</th>
                            <th class="px-5 py-3 text-emerald-600">SUBMIT</th>
                            <th class="px-5 py-3 text-rose-600">REJECT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detailPerDesa as $kecamatan => $desas)
                            @php
                                $subTarget = $desas->sum('total_target');
                                $subOpen = $desas->sum('total_open');
                                $subSubmit = $desas->sum('total_submitted');
                                $subReject = $desas->sum('total_rejected');
                            @endphp
                            <tr class="bg-slate-50/80 border-t border-slate-200/50">
                                <td class="px-5 py-3 font-semibold text-slate-800">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        {{ $kecamatan }}
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-center font-bold text-slate-700">{{ number_format($subTarget) }}</td>
                                <td class="px-5 py-3 text-center font-medium text-blue-600">{{ number_format($subOpen) }}</td>
                                <td class="px-5 py-3 text-center font-medium text-emerald-600">{{ number_format($subSubmit) }}</td>
                                <td class="px-5 py-3 text-center font-medium text-rose-600">{{ number_format($subReject) }}</td>
                            </tr>
                            
                            @foreach ($desas as $desa)
                                <tr class="hover:bg-slate-50/50 transition-colors border-t border-slate-100">
                                    <td class="px-5 py-2.5 pl-12 text-slate-600">
                                        <div class="flex items-center gap-2 truncate max-w-[200px]" title="{{ $desa->desa }}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                                            {{ $desa->desa }}
                                        </div>
                                    </td>
                                    <td class="px-5 py-2.5 text-center text-slate-700 font-medium">{{ number_format($desa->total_target) }}</td>
                                    <td class="px-5 py-2.5 text-center text-slate-500">{{ number_format($desa->total_open) }}</td>
                                    <td class="px-5 py-2.5 text-center text-slate-700">{{ number_format($desa->total_submitted) }}</td>
                                    <td class="px-5 py-2.5 text-center text-slate-500">{{ number_format($desa->total_rejected) }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Chart -->
        <div class="glass rounded-2xl border border-white/30 p-6 sticky top-6">
            <h3 class="font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Target per Desa
            </h3>
            <div class="relative w-full" style="height: {{ max(300, min(600, $stats->total_desa * 35)) }}px;">
                <canvas id="desaChart"></canvas>
            </div>
            <div class="mt-4 flex justify-center gap-6 text-xs">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-sm bg-emerald-500"></span>
                    <span class="text-slate-600">SUBMITTED</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-sm bg-blue-500"></span>
                    <span class="text-slate-600">OPEN</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-sm bg-rose-500"></span>
                    <span class="text-slate-600">REJECTED</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('desaChart').getContext('2d');
        const rawData = @json($detailPerDesa);
        
        let labels = [];
        let openData = [];
        let submitData = [];
        let rejectData = [];

        Object.values(rawData).forEach(kecamatanGroup => {
            kecamatanGroup.forEach(desa => {
                labels.push(desa.desa.length > 20 ? desa.desa.substring(0, 18) + '...' : desa.desa);
                openData.push(desa.total_open);
                submitData.push(desa.total_submitted);
                rejectData.push(desa.total_rejected);
            });
        });

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'SUBMITTED',
                        data: submitData,
                        backgroundColor: '#10B981',
                        borderRadius: 6,
                        barPercentage: 0.7,
                        categoryPercentage: 0.8,
                    },
                    {
                        label: 'OPEN',
                        data: openData,
                        backgroundColor: '#3B82F6',
                        borderRadius: 6,
                        barPercentage: 0.7,
                        categoryPercentage: 0.8,
                    },
                    {
                        label: 'REJECTED',
                        data: rejectData,
                        backgroundColor: '#EF4444',
                        borderRadius: 6,
                        barPercentage: 0.7,
                        categoryPercentage: 0.8,
                    }
                ]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        stacked: true,
                        grid: { color: '#e2e8f0', drawBorder: false },
                        ticks: { 
                            font: { size: 10, family: 'Inter' },
                            callback: function(value) {
                                return value >= 1000 ? (value/1000).toFixed(1) + 'k' : value;
                            }
                        }
                    },
                    y: {
                        stacked: true,
                        grid: { display: false, drawBorder: false },
                        ticks: { 
                            font: { size: 10, family: 'Inter' },
                            autoSkip: false
                        }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#f1f5f9',
                        bodyColor: '#cbd5e1',
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + new Intl.NumberFormat('id-ID').format(context.raw);
                            }
                        }
                    }
                },
                layout: {
                    padding: { top: 10, bottom: 10 }
                }
            }
        });
    });
</script>
@endsection