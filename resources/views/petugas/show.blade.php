@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 pb-12">
    <!-- Breadcrumb & Back Button -->
    <div class="flex items-center justify-between">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Dashboard
        </a>
    </div>

    <!-- Header Officer Info -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50 rounded-full blur-3xl opacity-50 -mr-20 -mt-20 pointer-events-none"></div>
        <div class="relative z-10 flex items-center gap-5">
            <div class="w-16 h-16 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-2xl font-bold shadow-inner">
                {{ strtoupper(substr($petugas->nama, 0, 1)) }}
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ $petugas->nama }}</h1>
                <p class="text-gray-500 mt-1 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    {{ $petugas->email }}
                </p>
            </div>
        </div>
        
        <div class="relative z-10 w-full md:w-72 bg-gray-50 rounded-xl p-4 border border-gray-100">
            <div class="flex justify-between items-end mb-2">
                <span class="text-sm font-medium text-gray-500">Progress Penugasan</span>
                <span class="text-2xl font-bold text-gray-900">{{ $persenSelesai }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-emerald-500 h-2.5 rounded-full transition-all duration-1000" style="width: {{ $persenSelesai }}%"></div>
            </div>
            <p class="text-xs text-gray-400 mt-2 text-right">{{ number_format($stats->total_submitted) }} dari {{ number_format($stats->total_target) }} Dokumen</p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Total Target</p>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($stats->total_target) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-2 border-blue-500">
            <p class="text-xs font-semibold text-blue-500 uppercase tracking-wider mb-1">Total OPEN</p>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($stats->total_open) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-2 border-green-500">
            <p class="text-xs font-semibold text-green-500 uppercase tracking-wider mb-1">Total SUBMITTED</p>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($stats->total_submitted) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-2 border-red-500">
            <p class="text-xs font-semibold text-red-500 uppercase tracking-wider mb-1">Total REJECTED</p>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($stats->total_rejected) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        <!-- Breakdown Table -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <h3 class="font-semibold text-gray-800">Detail Wilayah Penugasan</h3>
                <span class="text-xs font-medium bg-blue-100 text-blue-800 px-2.5 py-1 rounded-full">{{ count($detailPerDesa) }} Kecamatan, {{ $stats->total_desa }} Desa</span>
            </div>
            
            <div class="overflow-x-auto max-h-[600px] overflow-y-auto relative">
                <table class="w-full text-left border-collapse text-sm">
                    <thead class="sticky top-0 bg-white shadow-sm ring-1 ring-gray-100 z-10">
                        <tr class="text-gray-500 font-semibold uppercase text-[10px] tracking-wider text-center">
                            <th class="px-4 py-3 text-left">Wilayah</th>
                            <th class="px-4 py-3">Target</th>
                            <th class="px-4 py-3 text-blue-600">OPEN</th>
                            <th class="px-4 py-3 text-green-600">SUBMIT</th>
                            <th class="px-4 py-3 text-red-600">REJECT</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($detailPerDesa as $kecamatan => $desas)
                            @php
                                $subTarget = $desas->sum('total_target');
                                $subOpen = $desas->sum('total_open');
                                $subSubmit = $desas->sum('total_submitted');
                                $subReject = $desas->sum('total_rejected');
                            @endphp
                            <!-- Kecamatan Group Header -->
                            <tr class="bg-gray-50/80">
                                <td class="px-4 py-3 font-semibold text-gray-800 flex items-center gap-2 text-xs">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    {{ $kecamatan }}
                                </td>
                                <td class="px-4 py-3 text-center font-bold text-gray-700 bg-gray-100/50">{{ number_format($subTarget) }}</td>
                                <td class="px-4 py-3 text-center font-medium text-blue-600/80 bg-blue-50/30">{{ number_format($subOpen) }}</td>
                                <td class="px-4 py-3 text-center font-medium text-green-600/80 bg-green-50/30">{{ number_format($subSubmit) }}</td>
                                <td class="px-4 py-3 text-center font-medium text-red-600/80 bg-red-50/30">{{ number_format($subReject) }}</td>
                            </tr>
                            
                            <!-- Desa Rows -->
                            @foreach ($desas as $desa)
                                <tr class="hover:bg-blue-50/10 transition-colors">
                                    <td class="px-4 py-2.5 pl-10 text-gray-600 text-xs flex items-center gap-2 truncate max-w-[200px]" title="{{ $desa->desa }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-300 shrink-0"></span>
                                        {{ $desa->desa }}
                                    </td>
                                    <td class="px-4 py-2.5 text-center text-gray-700 font-medium">{{ number_format($desa->total_target) }}</td>
                                    <td class="px-4 py-2.5 text-center text-gray-500">{{ number_format($desa->total_open) }}</td>
                                    <td class="px-4 py-2.5 text-center text-gray-700">{{ number_format($desa->total_submitted) }}</td>
                                    <td class="px-4 py-2.5 text-center text-gray-500">{{ number_format($desa->total_rejected) }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Horizontal Stacked Bar Chart for Desa -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-6">
            <h3 class="font-semibold text-gray-800 mb-4">Target per Desa</h3>
            <div class="relative w-full" style="height: {{ max(300, min(600, $stats->total_desa * 35)) }}px;">
                <canvas id="desaChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('desaChart').getContext('2d');
        
        // Prepare data from PHP grouped collection
        const rawData = @json($detailPerDesa);
        
        let labels = [];
        let openData = [];
        let submitData = [];
        let rejectData = [];

        Object.values(rawData).forEach(kecamatanGroup => {
            kecamatanGroup.forEach(desa => {
                labels.push(desa.desa);
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
                        backgroundColor: '#10B981', // green-500
                        barThickness: 16,
                    },
                    {
                        label: 'OPEN',
                        data: openData,
                        backgroundColor: '#3B82F6', // blue-500
                        barThickness: 16,
                    },
                    {
                        label: 'REJECTED',
                        data: rejectData,
                        backgroundColor: '#EF4444', // red-500
                        barThickness: 16,
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
                        grid: { color: '#f3f4f6' },
                        ticks: { font: { size: 10 } }
                    },
                    y: {
                        stacked: true,
                        grid: { display: false },
                        ticks: { 
                            font: { size: 10 },
                            autoSkip: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12, usePointStyle: true, pointStyle: 'circle' }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                }
            }
        });
    });
</script>
@endsection
