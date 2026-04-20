@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Page -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Import Data Excel</h1>
        <p class="mt-1 text-sm text-gray-500">Mengupload file baru akan <strong class="text-red-600">menghapus dan mengganti</strong> semua data yang ada sebelumnya.</p>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
    <div class="p-4 border-l-4 border-green-400 bg-green-50 rounded-r-lg flex items-start">
        <svg class="h-5 w-5 text-green-400 mt-0.5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <p class="text-sm text-green-800">{{ session('success') }}</p>
    </div>
    @endif

    @if (session('error') || $errors->any())
    <div class="p-4 border-l-4 border-red-400 bg-red-50 rounded-r-lg flex items-start">
        <svg class="h-5 w-5 text-red-400 mt-0.5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <div>
            @if(session('error'))
                <p class="text-sm text-red-800">{{ session('error') }}</p>
            @endif
            @if($errors->any())
                <ul class="text-sm text-red-800 list-disc list-inside mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    @endif

    <!-- Upload Form Card -->
    <div class="bg-white border text-gray-800 border-gray-200 rounded-xl shadow-sm overflow-hidden" x-data="{ isUploading: false }">
        <div class="p-6">
            <form action="{{ route('import.store') }}" method="POST" enctype="multipart/form-data" @submit="isUploading = true">
                @csrf
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih File Excel (.xlsx, .xls)</label>
                    <input type="file" name="file" accept=".xlsx, .xls" required
                           class="block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2.5 file:px-4
                                  file:rounded-lg file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-blue-50 file:text-blue-700
                                  hover:file:bg-blue-100 cursor-pointer
                                  border border-gray-300 rounded-lg bg-gray-50">
                    <p class="mt-2 text-xs text-gray-500">Maksimal ukuran file: 10MB.</p>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password Import</label>
                    <input type="password" name="password" required placeholder="Masukkan password"
                           class="block w-full text-sm text-gray-900 py-2.5 px-4 focus:ring-blue-500 focus:border-blue-500
                                  border border-gray-300 rounded-lg bg-gray-50">
                </div>

                <!-- 
                <div class="bg-blue-50/50 p-4 rounded-lg border border-blue-100 mb-5">
                    <h4 class="text-xs font-semibold text-blue-800 uppercase tracking-wider mb-2">Format yang dibutuhkan</h4>
                    <p class="text-sm text-gray-600 mb-2">Pastikan baris pertama (header) mengandung kolom persis seperti berikut:</p>
                    <div class="flex flex-wrap gap-2 text-xs font-mono text-gray-700">
                        <span class="bg-white px-2 py-1 rounded border border-gray-200 shadow-sm">level_1_full_code</span>
                        <span class="bg-white px-2 py-1 rounded border border-gray-200 shadow-sm">level_1_name</span>
                        <span class="bg-white px-2 py-1 rounded border border-gray-200 shadow-sm">level_2_full_code</span>
                        <span class="bg-white px-2 py-1 rounded border border-gray-200 shadow-sm">level_2_name</span>
                        <span class="bg-white px-2 py-1 rounded border border-gray-200 shadow-sm">level_3_full_code</span>
                        <span class="bg-white px-2 py-1 rounded border border-gray-200 shadow-sm">level_3_name</span>
                        <span class="bg-white px-2 py-1 rounded border border-gray-200 shadow-sm">level_4_full_code</span>
                        <span class="bg-white px-2 py-1 rounded border border-gray-200 shadow-sm">level_4_name</span>
                        <span class="bg-white px-2 py-1 rounded border border-gray-200 shadow-sm">email_pencacah</span>
                        <span class="bg-white px-2 py-1 rounded border border-gray-200 shadow-sm">assignment_status_alias</span>
                        <span class="bg-white px-2 py-1 rounded border border-gray-200 shadow-sm">Jumlah Dokumen</span>
                    </div>
                </div> 
                -->

                <div class="flex justify-end">
                    <button type="submit" 
                            class="px-5 py-2.5 bg-blue-600 text-white font-medium rounded-lg shadow hover:bg-blue-700 transition flex items-center gap-2 disabled:opacity-70"
                            :disabled="isUploading">
                        <svg x-show="!isUploading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        <svg x-show="isUploading" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display:none;"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span x-text="isUploading ? 'Memproses Data...' : 'Upload & Proses'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Latest Import Card -->
    @if ($latestImport)
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mt-6">
        <div class="border-b border-gray-100 bg-gray-50/50 px-6 py-4">
            <h3 class="font-medium text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Informasi Dataset Saat Ini
            </h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Nama File</p>
                <p class="text-gray-800 font-medium break-all">{{ $latestImport->original_name }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Status</p>
                @if ($latestImport->status === 'done')
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Sukses
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Gagal
                    </span>
                    <p class="text-xs text-red-600 mt-1">{{ $latestImport->notes }}</p>
                @endif
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Tanggal Diupload</p>
                <p class="text-gray-800">{{ $latestImport->imported_at->format('d F Y, H:i') }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Total Baris Diimport</p>
                <p class="text-gray-800 font-semibold">{{ number_format($latestImport->total_rows) }} <span class="text-gray-500 text-sm font-normal">data</span></p>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
