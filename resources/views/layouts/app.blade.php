<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GC PBI - Dashboard Monitoring</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Smooth transitions */
        * {
            transition-property: background-color, border-color, box-shadow, transform;
            transition-duration: 200ms;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Glass morphism utilities */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .glass-light {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        /* Gradient animations */
        @keyframes gradient-shift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .gradient-animate {
            background-size: 200% 200%;
            animation: gradient-shift 8s ease infinite;
        }

        /* Card hover effects */
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.05), 0 8px 10px -6px rgb(0 0 0 / 0.05);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-slate-50 via-white to-slate-100 flex flex-col h-screen overflow-hidden antialiased"
    x-data="{ 
        showImportModal: false,
        sidebarOpen: false,
        scrollY: 0
    }" @scroll.window="scrollY = window.scrollY">

    <!-- Animated Background Elements -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-200/20 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -left-40 w-80 h-80 bg-purple-200/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 right-1/4 w-96 h-96 bg-emerald-200/20 rounded-full blur-3xl"></div>
    </div>

    <!-- Top Navigation Header -->
    <header class="glass border-b border-white/20 z-30 shrink-0 shadow-sm relative"
        :class="{ 'shadow-md': scrollY > 10 }">
        <div class="px-6 lg:px-8 py-4 flex justify-between items-center">
            <!-- Logo & Title -->
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('logo/logo-bps.svg') }}" alt="BPS" class="h-10 w-auto">
                    <div>
                        <h1 class="text-xl font-bold text-slate-800">
                            GC PBI Monitoring
                        </h1>
                        <p class="text-xs text-slate-500 font-medium">BPS Kabupaten Ogan Ilir</p>
                    </div>
                </div>
            </div>

            <!-- Right Section -->
            <div class="flex items-center gap-4">
                @if(isset($latestImport) && $latestImport)
                    <div
                        class="hidden lg:flex items-center gap-3 px-4 py-2 glass-light rounded-2xl border border-white/30 shadow-sm">
                        <div class="relative">
                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                            <div class="absolute inset-0 w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping opacity-75">
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-medium text-slate-500">Dataset</span>
                            <span class="text-sm font-semibold text-slate-800 max-w-[200px] truncate"
                                title="{{ $latestImport->original_name }}">
                                {{ $latestImport->original_name }}
                            </span>
                        </div>
                        <span class="text-xs text-slate-400">•</span>
                        <span class="text-xs text-slate-500">
                            {{ \Carbon\Carbon::parse($latestImport->imported_at)->locale('id')->diffForHumans() }}
                        </span>
                    </div>
                @endif

                @unless(request()->routeIs('dashboard'))
                    <a href="{{ route('dashboard') }}"
                        class="group flex items-center gap-2 px-5 py-2.5 glass-light rounded-2xl border border-white/30 hover:bg-white/60 text-slate-700 font-medium shadow-sm transition-all text-sm">
                        <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                @endunless
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto relative z-10 flex flex-col">
        <div class="flex-1 py-4 px-4 sm:px-6 lg:px-8">
            <!-- Session Alerts -->
            <div class="max-w-7xl mx-auto mb-6 space-y-3">
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        class="glass rounded-2xl border-l-4 border-emerald-500 p-4 flex items-start shadow-lg">
                        <div class="flex items-center gap-3 flex-1">
                            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-slate-800">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                @endif

                @if (session('error') || $errors->any())
                    <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        class="glass rounded-2xl border-l-4 border-rose-500 p-4 flex items-start shadow-lg">
                        <div class="flex items-start gap-3 flex-1">
                            <div class="w-8 h-8 bg-rose-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                @if(session('error'))
                                    <p class="text-sm font-medium text-slate-800">{{ session('error') }}</p>
                                @endif
                                @if($errors->any())
                                    <ul class="text-sm text-slate-700 space-y-1 mt-1">
                                        @foreach ($errors->all() as $error)
                                            <li class="flex items-center gap-2">
                                                <span class="w-1 h-1 bg-rose-400 rounded-full"></span>
                                                {{ $error }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                        <button @click="show = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>

            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="py-5 border-t border-slate-200/60 text-center text-sm text-slate-500 glass-light shrink-0">
            <div class="flex items-center justify-center gap-2">
                <span>&copy; 2026 BPS Kabupaten Ogan Ilir</span>
                <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                <span>GC PBI Monitoring System v1.0</span>
            </div>
        </footer>
    </main>

    <!-- Import Modal -->
    <div x-cloak x-show="showImportModal" class="relative z-50" x-data="{ 
        loading: false,
        fileName: '',
        password: '',
        fileSelected: false
    }">
        <div x-show="showImportModal" x-transition.opacity.duration.300ms
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40"></div>

        <div class="fixed inset-0 z-50 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div x-show="showImportModal" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    @click.away="!loading && (showImportModal = false)"
                    class="relative w-full max-w-md transform overflow-hidden rounded-2xl glass border border-white/30 shadow-2xl">

                    <form action="{{ route('import.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Loading Overlay -->
                        <div x-show="loading" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            class="absolute inset-0 bg-white/80 backdrop-blur-sm z-10 flex flex-col items-center justify-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="relative">
                                    <div
                                        class="w-16 h-16 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin">
                                    </div>
                                    <svg class="absolute inset-0 w-16 h-16 text-blue-600 p-3" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <p class="font-semibold text-slate-800">Sedang Mengimport Data...</p>
                                    <p class="text-sm text-slate-500 mt-1">Mohon tunggu, proses mungkin memerlukan waktu
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-slate-800">Upload File Excel</h3>
                                    <p class="text-sm text-slate-500">Upload target dan status penugasan</p>
                                </div>
                            </div>

                            <!-- Info Dataset Terakhir -->
                            @if(isset($latestImport) && $latestImport)
                                <div class="mb-5 p-4 bg-amber-50/80 rounded-xl border border-amber-200">
                                    <div class="flex items-start gap-3">
                                        <div
                                            class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center shrink-0">
                                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-amber-800 mb-1">Peringatan!</p>
                                            <p class="text-xs text-amber-700 mb-2">Upload file baru akan <strong>menghapus
                                                    semua data yang ada saat ini</strong> dan menggantinya dengan data baru.
                                            </p>
                                            <div class="text-xs text-amber-600 bg-amber-100/50 px-3 py-1.5 rounded-lg">
                                                <span class="font-medium">Dataset saat ini:</span>
                                                <span class="font-semibold">{{ $latestImport->original_name }}</span>
                                                <span class="mx-1">•</span>
                                                <span>{{ \Carbon\Carbon::parse($latestImport->imported_at)->locale('id')->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="space-y-5">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Pilih File</label>
                                    <div class="relative">
                                        <input type="file" name="file" id="excel-file" required accept=".xlsx,.xls"
                                            @change="fileName = $event.target.files[0]?.name || ''; fileSelected = $event.target.files.length > 0"
                                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gradient-to-r file:from-blue-500 file:to-blue-600 file:text-white hover:file:from-blue-600 hover:file:to-blue-700 file:shadow-md file:shadow-blue-500/25 file:cursor-pointer file:transition-all focus:outline-none border border-slate-200/50 rounded-xl bg-slate-50/50 p-1">
                                    </div>
                                    <p class="mt-1.5 text-xs text-slate-400 flex items-center justify-between">
                                        <span>Format: .xlsx, .xls (Maks. 10MB)</span>
                                        <span x-show="fileName" x-text="fileName"
                                            class="text-blue-600 font-medium truncate max-w-[180px]"></span>
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                                    <input type="password" name="password" id="password" required x-model="password"
                                        class="block w-full px-4 py-3 glass-light rounded-xl border border-white/30 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all"
                                        placeholder="Masukkan password keamanan">
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-100/50 px-6 py-4 flex justify-end gap-3 border-t border-slate-200/50">
                            <button type="button"
                                @click="showImportModal = false; loading = false; fileName = ''; password = ''; fileSelected = false"
                                class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 hover:bg-slate-200/50 rounded-xl transition-all">
                                Batal
                            </button>
                            <button type="submit" @click="if(fileSelected && password.length > 0) { loading = true; } else { 
                                    if(!fileSelected) alert('Silakan pilih file Excel terlebih dahulu'); 
                                    else if(password.length === 0) alert('Silakan masukkan password'); 
                                    $event.preventDefault(); 
                                }"
                                class="relative px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition-all">
                                <span x-show="!loading">Upload & Import</span>
                                <span x-show="loading" class="flex items-center gap-2">
                                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Mengimport...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>